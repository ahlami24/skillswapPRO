<?php 
require_once 'config/app.php'; 
require_once 'includes/header.php'; 
?>

<style>
    html { scroll-behavior: smooth; }
</style>

<main class="container mx-auto px-6 py-20 text-center">
    <span class="bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider">Student-led Learning</span>
    <h1 class="text-6xl font-extrabold text-gray-900 mt-6 mb-8 leading-tight">
        Trade your <span class="text-blue-600">Coding</span> skills <br> for <span class="text-purple-600">Design</span> skills.
    </h1>
    <p class="text-gray-500 text-xl max-w-2xl mx-auto mb-10">
        The community for students to exchange knowledge. No money involved, just pure skill-building with your peers.
    </p>
    <div class="flex justify-center gap-4">
        <a href="register.php" class="bg-gray-900 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-800 transition shadow-xl">Get Started Free</a>
        <a href="#how" class="bg-white text-gray-700 border border-gray-200 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 transition">How it Works</a>
    </div>
</main>

<section id="how" class="py-24 bg-slate-50 border-t border-gray-100">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-gray-900 mb-4">Simple, Peer-to-Peer Learning</h2>
            <p class="text-gray-500">No instructors, no fees—just students helping students.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-xl font-bold mb-6">1</div>
                <h3 class="text-xl font-bold mb-4">List Your Skills</h3>
                <p class="text-gray-500 leading-relaxed">Tell us what you're good at (Have) and what you want to learn (Want).</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 bg-purple-600 text-white rounded-2xl flex items-center justify-center text-xl font-bold mb-6">2</div>
                <h3 class="text-xl font-bold mb-4">Find Your Match</h3>
                <p class="text-gray-500 leading-relaxed">Our Smart Dashboard shows you students who complement your skills perfectly.</p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 bg-green-600 text-white rounded-2xl flex items-center justify-center text-xl font-bold mb-6">3</div>
                <h3 class="text-xl font-bold mb-4">Start the Swap</h3>
                <p class="text-gray-500 leading-relaxed">Use our built-in chat to coordinate and share knowledge with your peers.</p>
            </div>
        </div>
        
        <div class="mt-16 text-center">
            <a href="register.php" class="text-blue-600 font-bold hover:underline">Ready to join the community? &rarr;</a>
        </div>
    </div>
</section>

</body>
</html>