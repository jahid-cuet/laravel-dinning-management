<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dining Dashboard - CUET</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">


 @include('Frontend.layouts.sidebar')


    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">My Running Dining Meals</h2>

        <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Lunch</th>
                        <th class="p-3">Dinner</th>
                        <th class="p-3">Lunch</th>
                        <th class="p-3">Dinner</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="p-3 text-center text-indigo-600">🍽<br>07/01/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>07/01/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>10/01/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>10/01/2025</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3 text-center text-indigo-600">🍽<br>08/01/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>08/01/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>11/01/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>11/01/2025</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3 text-center text-indigo-600">🍽<br>09/02/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>09/02/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>12/02/2025</td>
                        <td class="p-3 text-center text-indigo-600">🍽<br>12/02/2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
