<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Cart Management</title>
    <style>
        /* CSS Langsung di dalam File Blade */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #00264d;
            color: white;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin: 0 10px;
        }

        .sidebar {
            width: 20%;
            background-color: #ffffff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .container {
            display: flex;
            margin: 20px;
        }

        .products {
            width: 80%;
            padding: 20px;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .order-btn {
            background: #ffa500;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h2>LOGO</h2>
        </div>
        <nav>
            <ul>
                <li><a href="#">Account</a></li>
                <li><a href="#">Resources</a></li>
                <li><a href="#">Support Center</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <!-- Sidebar Filter -->
        <aside class="sidebar">
            <h3>Filter</h3>
            <ul>
                <li><input type="checkbox" id="civil-engineering"> <label for="civil-engineering">Civil Engineering</label></li>
                <li><input type="checkbox" id="constructions"> <label for="constructions">Constructions</label></li>
                <li><input type="checkbox" id="railway"> <label for="railway">Railway</label></li>
                <li><input type="checkbox" id="bridges"> <label for="bridges">Bridges</label></li>
            </ul>

            <h3>Company</h3>
            <div class="company-logos">
                <img src="images/hyundai.png" alt="Hyundai">
                <img src="images/tata.png" alt="Tata">
                <img src="images/hbis.png" alt="HBIS">
                <img src="images/posco.png" alt="POSCO">
                <img src="images/arscelormittal.png" alt="ArcelorMittal">
                <img src="images/nippon.png" alt="Nippon Steel">
            </div>
        </aside>

        <!-- Main Content -->
        <main class="products">
            <div class="search-bar">
                <input type="text" placeholder="Search product..." id="search">
            </div>

            <div class="product-grid">
                <!-- Contoh Produk -->
                @foreach ($products as $product)
                    <div class="product-card">
                        <img src="{{ $product->image }}" alt="{{ $product->nama }}">
                        <div class="product-details">
                            <p>Manufacturer: {{ $product->manufacturer }}</p>
                            <p>Product: {{ $product->nama }}</p>
                            <p>Type: {{ $product->tipe }}</p>
                            <button class="order-btn">Order</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>
