<?php 
require_once 'config/app.php'; 
require_once 'config/db.php'; 

if(!isset($_SESSION['user_id'])) { redirect('login.php'); }
$user_id = $_SESSION['user_id'];

// --- HANDLE FORM SUBMISSIONS ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skill_id = $_POST['skill_id'];
    $type = $_POST['type']; // 'teach' or 'learn'

    if (isset($_POST['add_skill'])) {
        // Check if already exists to prevent duplicates
        $check = $conn->prepare("SELECT id FROM user_skills WHERE user_id = ? AND skill_id = ? AND type = ?");
        $check->execute([$user_id, $skill_id, $type]);
        if (!$check->fetch()) {
            $stmt = $conn->prepare("INSERT INTO user_skills (user_id, skill_id, type) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $skill_id, $type]);
        }
    } elseif (isset($_POST['remove_skill'])) {
        $stmt = $conn->prepare("DELETE FROM user_skills WHERE user_id = ? AND skill_id = ? AND type = ?");
        $stmt->execute([$user_id, $skill_id, $type]);
    }
    header("Location: manage_skills.php");
    exit();
}

// --- FETCH DATA ---
// 1. All available skills for the dropdown
$all_skills = $conn->query("SELECT * FROM skills ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// 2. My Teaching Skills
$stmt = $conn->prepare("SELECT s.id, s.name FROM skills s JOIN user_skills us ON s.id = us.skill_id WHERE us.user_id = ? AND us.type = 'teach'");
$stmt->execute([$user_id]);
$my_teaching = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. My Learning Skills
$stmt = $conn->prepare("SELECT s.id, s.name FROM skills s JOIN user_skills us ON s.id = us.skill_id WHERE us.user_id = ? AND us.type = 'learn'");
$stmt->execute([$user_id]);
$my_learning = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php'; 
?>

<div class="container mx-auto px-6 py-10 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8">Manage Your Skills</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-blue-600 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-chalkboard-user"></i> Skills I Teach
            </h2>
            
            <form method="POST" class="flex gap-2 mb-6">
                <input type="hidden" name="type" value="teach">
                <select name="skill_id" class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select a skill...</option>
                    <?php foreach($all_skills as $s): ?>
                        <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="add_skill" class="bg-blue-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700">+</button>
            </form>

            <div class="flex flex-wrap gap-2">
                <?php foreach($my_teaching as $skill): ?>
                    <form method="POST" class="inline">
                        <input type="hidden" name="skill_id" value="<?php echo $skill['id']; ?>">
                        <input type="hidden" name="type" value="teach">
                        <span class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium border border-blue-100">
                            <?php echo htmlspecialchars($skill['name']); ?>
                            <button type="submit" name="remove_skill" class="ml-2 text-blue-300 hover:text-red-500">&times;</button>
                        </span>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-indigo-600 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-book-open"></i> Skills I Want to Learn
            </h2>
            
            <form method="POST" class="flex gap-2 mb-6">
                <input type="hidden" name="type" value="learn">
                <select name="skill_id" class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">Select a skill...</option>
                    <?php foreach($all_skills as $s): ?>
                        <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="add_skill" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-indigo-700">+</button>
            </form>

            <div class="flex flex-wrap gap-2">
                <?php foreach($my_learning as $skill): ?>
                    <form method="POST" class="inline">
                        <input type="hidden" name="skill_id" value="<?php echo $skill['id']; ?>">
                        <input type="hidden" name="type" value="learn">
                        <span class="inline-flex items-center bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium border border-indigo-100">
                            <?php echo htmlspecialchars($skill['name']); ?>
                            <button type="submit" name="remove_skill" class="ml-2 text-indigo-300 hover:text-red-500">&times;</button>
                        </span>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <div class="mt-10 text-center">
        <a href="dashboard.php" class="text-gray-500 font-bold hover:text-gray-800">Done? Back to Dashboard</a>
    </div>
</div>