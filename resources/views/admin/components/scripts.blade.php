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
            loadTotalProducts();
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

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number || 0);
    }

    function loadTotalUsers() {
        fetch('/admin/total-users')
            .then(response => response.json())
            .then(data => {
                const totalElement = document.getElementById('totalUsers');
                if(totalElement) {
                    totalElement.textContent = formatNumber(data.total);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const totalElement = document.getElementById('totalUsers');
                if(totalElement) {
                    totalElement.textContent = 'Error';
                }
            });
    }

    function loadTotalProducts() {
        fetch('/admin/total-products')
            .then(response => response.json())
            .then(data => {
                const totalElement = document.getElementById('totalProducts');
                if(totalElement) {
                    totalElement.textContent = formatNumber(data.total);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const totalElement = document.getElementById('totalProducts');
                if(totalElement) {
                    totalElement.textContent = 'Error';
                }
            });
    }

    function loadTotalStock() {
        console.log('Fetching total stock...');
        fetch('/admin/total-stock')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                const totalElement = document.getElementById('totalStock');
                if(totalElement) {
                    totalElement.textContent = formatNumber(data.total);
                }
            })
            .catch(error => {
                console.error('Stock Error:', error);
                const totalElement = document.getElementById('totalStock');
                if(totalElement) {
                    totalElement.textContent = 'Error';
                }
            });
    }

    function loadLowStock() {
        console.log('Fetching low stock items...');
        fetch('/admin/low-stock')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                const totalElement = document.getElementById('lowStock');
                if(totalElement) {
                    totalElement.textContent = formatNumber(data.total);
                }
            })
            .catch(error => {
                console.error('Low Stock Error:', error);
                const totalElement = document.getElementById('lowStock');
                if(totalElement) {
                    totalElement.textContent = 'Error';
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadTotalUsers();
        loadTotalProducts();
        loadTotalStock();
        loadLowStock();
        
        // Refresh setiap 10 detik
        setInterval(() => {
            loadTotalUsers();
            loadTotalProducts();
            loadTotalStock();
            loadLowStock();
        }, 10000);
    });

    function loadOverviewStats() {
        loadTotalUsers();
        loadTotalProducts();
        // Tambahkan fungsi load statistik lainnya di sini
    }
</script> 