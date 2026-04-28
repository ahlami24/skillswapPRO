<?php 
require_once 'config/app.php'; 
require_once 'config/db.php'; 

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// 1. People who TEACH what I want to LEARN
$query_teachers = "
    SELECT DISTINCT u.id, u.name as user_name, s.name as skill_name 
    FROM users u
    JOIN user_skills us ON u.id = us.user_id
    JOIN skills s ON us.skill_id = s.id
    WHERE us.type = 'teach' 
    AND u.id != ?
    AND us.skill_id IN (SELECT skill_id FROM user_skills WHERE user_id = ? AND type = 'learn')
";
$stmt1 = $conn->prepare($query_teachers);
$stmt1->execute([$user_id, $user_id]);
$can_teach_me = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// 2. People who WANT TO LEARN what I TEACH
$query_students = "
    SELECT DISTINCT u.id, u.name as user_name, s.name as skill_name 
    FROM users u
    JOIN user_skills us ON u.id = us.user_id
    JOIN skills s ON us.skill_id = s.id
    WHERE us.type = 'learn' 
    AND u.id != ?
    AND us.skill_id IN (SELECT skill_id FROM user_skills WHERE user_id = ? AND type = 'teach')
";
$stmt2 = $conn->prepare($query_students);
$stmt2->execute([$user_id, $user_id]);
$need_my_help = $stmt2->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-10 max-w-6xl">
   <div class="mb-10 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-black text-gray-900 italic">Dashboard</h1>
        <p class="text-gray-500">Welcome back, <span class="text-blue-600 font-bold"><?php echo htmlspecialchars($user_name); ?></span>.</p>
    </div>
    <a href="manage_skills.php" class="bg-white border border-gray-200 px-6 py-3 rounded-2xl font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
        <i class="fa-solid fa-pen-to-square mr-2"></i> Edit My Skills
    </a>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        
        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-blue-600">
                <i class="fa-solid fa-graduation-cap"></i> People who can teach you
            </h2>
            <div class="space-y-4">
                <?php if(empty($can_teach_me)): ?>
                    <p class="text-gray-400 py-4 text-sm italic">Add more skills to your 'Want to Learn' list to see matches here.</p>
                <?php else: foreach($can_teach_me as $teacher): ?>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-gray-50">
                        <div>
                            <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($teacher['user_name']); ?></h4>
                            <span class="text-[10px] uppercase tracking-wider font-black text-blue-500">Teaches <?php echo htmlspecialchars($teacher['skill_name']); ?></span>
                        </div>
                        <a href="chat.php?with=<?php echo $teacher['id']; ?>" class="bg-blue-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-blue-700 transition">Chat</a>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-indigo-600">
                <i class="fa-solid fa-handshake-angle"></i> People who need your skills
            </h2>
            <div class="space-y-4">
                <?php if(empty($need_my_help)): ?>
                    <p class="text-gray-400 py-4 text-sm italic">No one is looking for the skills you teach yet.</p>
                <?php else: foreach($need_my_help as $student): ?>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-gray-50">
                        <div>
                            <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($student['user_name']); ?></h4>
                            <span class="text-[10px] uppercase tracking-wider font-black text-indigo-500">Wants <?php echo htmlspecialchars($student['skill_name']); ?></span>
                        </div>
                        <a href="chat.php?with=<?php echo $student['id']; ?>" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 transition">Chat</a>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

    </div>
</div>