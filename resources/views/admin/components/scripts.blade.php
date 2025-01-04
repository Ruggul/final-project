<script>
    function showContent(contentId) {
    
        document.getElementById('overview-content').classList.add('hidden');
        document.getElementById('users-content').classList.add('hidden');
        document.getElementById('products-content').classList.add('hidden');
        document.getElementById('statistics-content').classList.add('hidden');

        
        document.getElementById(contentId + '-content').classList.remove('hidden');

       
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

    function loadProducts() {
        console.log('Loading products...');
        fetch('/admin/products')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(products => {
                console.log('Products loaded:', products);
                const tbody = document.getElementById('productsTableBody');
                tbody.innerHTML = '';
                
                products.forEach(product => {
                    tbody.innerHTML += `
                        <tr class="border-b">
                            <td class="px-6 py-4">${product.kode_barang}</td>
                            <td class="px-6 py-4">${product.nama_barang}</td>
                            <td class="px-6 py-4">${product.deskripsi || '-'}</td>
                            <td class="px-6 py-4">${product.stok}</td>
                            <td class="px-6 py-4">${product.satuan}</td>
                            <td class="px-6 py-4">Rp ${formatNumber(product.harga_satuan)}</td>
                            <td class="px-6 py-4">
                                <button onclick="editProduct(${product.id})" class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-800">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error loading products:', error);
            });
    }

    function editProduct(id) {
        fetch(`/admin/products/${id}`)
            .then(response => response.json())
            .then(product => {
                document.getElementById('editProductId').value = product.id;
                document.getElementById('editKodeBarang').value = product.kode_barang;
                document.getElementById('editNamaBarang').value = product.nama_barang;
                document.getElementById('editDeskripsi').value = product.deskripsi;
                document.getElementById('editStok').value = product.stok;
                document.getElementById('editSatuan').value = product.satuan;
                document.getElementById('editHargaSatuan').value = product.harga_satuan;
                document.getElementById('editModal').classList.remove('hidden');
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editProductId').value;
        
        
        const formData = {
            nama_barang: document.getElementById('editNamaBarang').value,
            deskripsi: document.getElementById('editDeskripsi').value,
            stok: parseInt(document.getElementById('editStok').value),
            satuan: document.getElementById('editSatuan').value,
            harga_satuan: parseFloat(document.getElementById('editHargaSatuan').value)
        };
        
        console.log('Sending data:', formData);
        
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Menyimpan...';
        
        fetch(`/admin/products/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(JSON.stringify(err));
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.message) {
                alert('Produk berhasil diperbarui!');
                closeEditModal();
                loadProducts();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data: ' + error.message);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Simpan';
        });
    });

    function deleteProduct(id) {
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            fetch(`/admin/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                loadProducts();
            })
            .catch(error => console.error('Error:', error));
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadTotalUsers();
        loadTotalProducts();
        loadTotalStock();
        loadLowStock();
        
        
        setInterval(() => {
            loadTotalUsers();
            loadTotalProducts();
            loadTotalStock();
            loadLowStock();
        }, 10000);

        if (document.getElementById('products-content')) {
            loadProducts();
        }
    });

    function loadOverviewStats() {
        loadTotalUsers();
        loadTotalProducts();
        // Tambahkan fungsi load statistik lainnya di sini
    }
</script> 