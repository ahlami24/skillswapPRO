<?php 
require_once 'config/app.php'; 
require_once 'config/db.php'; 

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }
$user_id = $_SESSION['user_id'];

/**
 * THE SMART EXCHANGE QUERY
 * This checks for 'teach' and 'learn' types. 
 * If your DB uses 'have' and 'want', simply swap those words below.
 */
$query = "
    SELECT u.id, u.name,
    -- 1. All skills they offer to teach
    (SELECT GROUP_CONCAT(s.name SEPARATOR ', ') 
     FROM user_skills us 
     JOIN skills s ON us.skill_id = s.id 
     WHERE us.user_id = u.id AND us.type = 'teach') as skills_they_offer,

    -- 2. Skills they teach that YOU want to learn
    (SELECT GROUP_CONCAT(s.name SEPARATOR ', ') 
     FROM user_skills us 
     JOIN skills s ON us.skill_id = s.id 
     WHERE us.user_id = u.id AND us.type = 'teach'
     AND us.skill_id IN (SELECT skill_id FROM user_skills WHERE user_id = ? AND type = 'learn')) as matching_for_you,

    -- 3. Skills YOU teach that THEY want to learn
    (SELECT GROUP_CONCAT(s.name SEPARATOR ', ') 
     FROM user_skills us 
     JOIN skills s ON us.skill_id = s.id 
     WHERE us.user_id = u.id AND us.type = 'learn'
     AND us.skill_id IN (SELECT skill_id FROM user_skills WHERE user_id = ? AND type = 'teach')) as matching_for_them

    FROM users u 
    WHERE u.id != ? 
    ORDER BY (matching_for_you IS NOT NULL) DESC
";

$stmt = $conn->prepare($query);
$stmt->execute([$user_id, $user_id, $user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-10">
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">Explore Community</h1>
            <p class="text-gray-500 mt-1">Discover students ready to swap knowledge with you.</p>
        </div>
        
        <div class="relative w-full md:w-96">
            <input type="text" id="skillSearch" placeholder="Search by skill or name..." 
                   class="w-full pl-12 pr-4 py-4 bg-white border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
            <div class="absolute left-4 top-4 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-lg"></i>
            </div>
        </div>
    </div>

    <?php if(empty($users)): ?>
        <div class="bg-white p-20 rounded-3xl text-center border-2 border-dashed border-gray-100">
            <p class="text-gray-400 text-lg">No other students found yet. Be the first to invite a peer!</p>
        </div>
    <?php else: ?>
        <div id="userGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($users as $u): ?>
                <?php $firstName = explode(' ', trim($u['name']))[0]; ?>
                
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div>
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-2xl flex items-center justify-center font-bold text-2xl shadow-lg shadow-blue-100">
                                <?= strtoupper(substr($u['name'], 0, 1)) ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-gray-900"><?= htmlspecialchars($u['name']) ?></h4>
                                <div class="flex items-center gap-1 text-green-500 text-[10px] font-black uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    Available Now
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="p-5 rounded-2xl bg-blue-50 border border-blue-100/50">
                                <p class="text-[10px] font-black text-blue-600 uppercase mb-2 tracking-widest">
                                    <?= $firstName ?> can teach you:
                                </p>
                                <p class="text-md font-bold text-blue-900">
                                    <?= $u['matching_for_you'] ?: ($u['skills_they_offer'] ?: 'General skills') ?>
                                </p>
                            </div>

                            <div class="p-5 rounded-2xl bg-purple-50 border border-purple-100/50">
                                <p class="text-[10px] font-black text-purple-600 uppercase mb-2 tracking-widest">
                                    You can teach <?= $firstName ?>:
                                </p>
                                <p class="text-md font-bold text-purple-900">
                                    <?= $u['matching_for_them'] ?: '<span class="text-gray-400 font-medium italic text-sm">Nothing ' . $firstName . ' needs yet</span>' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <a href="chat.php?with=<?= $u['id'] ?>" class="group block w-full text-center py-4 bg-gray-900 text-white rounded-2xl font-bold hover:bg-blue-600 transition-all duration-300 shadow-lg shadow-gray-200">
                        Message <?= $firstName ?> 
                        <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('skillSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('#userGrid > div');

    cards.forEach(card => {
        const content = card.textContent.toLowerCase();
        if (content.includes(searchTerm)) {
            card.style.display = "flex";
            card.style.opacity = "1";
        } else {
            card.style.display = "none";
            card.style.opacity = "0";
        }
    });
});
</script>

</body>
</html>