<script>
    function showContent(contentId) {
        // Hide all content sections
        document.getElementById('overview-content').classList.add('hidden');
        document.getElementById('users-content').classList.add('hidden');
        document.getElementById('products-content').classList.add('hidden');
        document.getElementById('statistics-content').classList.add('hidden');

        // Show selected content
        document.getElementById(contentId + '-content').classList.remove('hidden');

        // Jika memilih menu users, load data users
        if(contentId === 'users') {
            loadUsers();
        }

        if(contentId === 'overview') {
            loadTotalUsers();
        }
    }

    function loadUsers() {
        fetch('/admin/users')
            .then(response => response.json())
            .then(users => {
                const tbody = document.getElementById('usersTableBody');
                tbody.innerHTML = '';
                
                users.forEach(user => {
                    let roleSpan = '';
                    switch(user.usertype) {
                        case '0':
                            roleSpan = '<span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full">User</span>';
                            break;
                        case '1':
                            roleSpan = '<span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">Admin</span>';
                            break;
                        case '2':
                            roleSpan = '<span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full">Factory</span>';
                            break;
                    }

                    tbody.innerHTML += `
                        <tr class="border-b">
                            <td class="px-6 py-4">#${user.id}</td>
                            <td class="px-6 py-4">${user.name}</td>
                            <td class="px-6 py-4">${user.email}</td>
                            <td class="px-6 py-4 text-center">${roleSpan}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error:', error));
    }


    function loadTotalUsers() {
        fetch('/admin/total-users')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalUsers').textContent = data.total;
            })
            .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadTotalUsers();
    });
</script> 