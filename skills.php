<?php 
require_once 'config/app.php'; 
require_once 'config/db.php'; 

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }
$user_id = $_SESSION['user_id'];

// Fetch User's Skills
$stmt = $conn->prepare("SELECT us.id, s.name, us.type, us.skill_level 
                        FROM user_skills us 
                        JOIN skills s ON us.skill_id = s.id 
                        WHERE us.user_id = ?");
$stmt->execute([$user_id]);
$my_skills = $stmt->fetchAll();

require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Skillset</h1>
            <p class="text-gray-500">Define what you bring to the community.</p>
        </div>
        <button onclick="document.getElementById('skillModal').classList.remove('hidden')" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-black transition">
            + Add New Skill
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div>
            <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-600 rounded-full"></span> I'm Teaching
            </h3>
            <div class="space-y-4">
                <?php foreach($my_skills as $s): if($s['type'] == 'teach'): ?>
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex justify-between items-center">
                        <div>
                            <p class="font-bold text-gray-800"><?php echo $s['name']; ?></p>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest"><?php echo $s['skill_level']; ?></span>
                        </div>
                        <a href="skill_actions.php?action=delete&id=<?php echo $s['id']; ?>" class="text-gray-300 hover:text-red-500"><i class="fa-solid fa-trash"></i></a>
                    </div>
                <?php endif; endforeach; ?>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 bg-purple-600 rounded-full"></span> I want to Learn
            </h3>
            <div class="space-y-4">
                <?php foreach($my_skills as $s): if($s['type'] == 'learn'): ?>
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex justify-between items-center">
                        <div>
                            <p class="font-bold text-gray-800"><?php echo $s['name']; ?></p>
                            <span class="text-xs font-bold text-purple-600 uppercase tracking-widest"><?php echo $s['skill_level']; ?></span>
                        </div>
                        <a href="skill_actions.php?action=delete&id=<?php echo $s['id']; ?>" class="text-gray-300 hover:text-red-500"><i class="fa-solid fa-trash"></i></a>
                    </div>
                <?php endif; endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div id="skillModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white max-w-md w-full rounded-3xl p-8 shadow-2xl">
        <h3 class="text-2xl font-bold mb-6">Add a Skill</h3>
        <form action="skill_actions.php?action=add" method="POST" class="space-y-4">
            <input type="text" name="skill_name" placeholder="Skill Name (e.g. Photoshop)" class="w-full px-4 py-3 bg-gray-50 rounded-xl outline-none border border-gray-100 focus:ring-2 focus:ring-blue-500" required>
            
            <select name="type" class="w-full px-4 py-3 bg-gray-50 rounded-xl outline-none border border-gray-100">
                <option value="teach">I want to Teach this</option>
                <option value="learn">I want to Learn this</option>
            </select>

            <select name="level" class="w-full px-4 py-3 bg-gray-50 rounded-xl outline-none border border-gray-100">
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
            </select>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('skillModal').classList.add('hidden')" class="flex-1 py-3 font-bold text-gray-500">Cancel</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200">Save Skill</button>
            </div>
        </form>
    </div>
</div>