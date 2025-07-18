    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md min-h-screen p-5">
        <div class="text-center mb-8">
            <img src="https://1.bp.blogspot.com/-cCNYariHpyE/XVQ-BS7sG3I/AAAAAAAACew/EgTPlvajRMw263ZU3fJUWeaj9mUW7LkCQCLcBGAs/s1600/cuetlogo.png" alt="CUET Logo" class="h-12 mx-auto mb-2">
            <h1 class="text-xl font-bold text-blue-700">CUET</h1>
        </div>

        <nav class="space-y-2">
            <a href="#" class="block px-4 py-2 rounded bg-blue-100 text-blue-700 font-semibold">Dashboard</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Profile</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">My Courses</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">My Hall</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Dining</a>
        </nav>

        <div class="mt-10">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded bg-red-100 text-red-600 hover:bg-red-200">
                    Logout
                </button>
            </form>
        </div>
    </aside>