<?php


$page = $_GET['page'] ?? 'shop';

switch ($page) {

    
    
    case 'add-cart':
        require '../app/helpers/cart.php';
        addToCart($_GET['id']);
        header('Location: ?page=cart');
        exit;

    case 'decrease-cart':
        require '../app/helperscart.php';
        decreaseCart($_GET['id']);
        header('Location: ?page=cart');
        exit;

    case 'remove-cart':
        require '../app/helpers/cart.php';
        removeFromCart($_GET['id']);
        header('Location: ?page=cart');
        exit;

    case 'cart':
        require '../app/views/shop/cart.php';
        break;

    case 'checkout':
        require '../app/views/shop/checkout.php';
        break;

    case 'checkout-process':
        require '../app/config/database.php';
        require '../app/helpers/cart.php';

        $nama   = $_POST['nama'] ?? '';
        $no_hp  = $_POST['no_hp'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $metode = $_POST['metode_pembayaran'] ?? '';

        $cart = getCart();

        $kode  = 'ORD-' . time();
        $total = 0;

        foreach ($cart as $id => $qty) {
            $q = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
            $p = mysqli_fetch_assoc($q);
            $total += $p['harga'] * $qty;
        }

        mysqli_query($conn,
            "INSERT INTO orders (kode_order,nama,no_hp,alamat,total,metode_pembayaran)
             VALUES ('$kode','$nama','$no_hp','$alamat','$total','$metode')"
        );

        $order_id = mysqli_insert_id($conn);

        foreach ($cart as $id => $qty) {
            $q = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
            $p = mysqli_fetch_assoc($q);

            mysqli_query($conn,
                "INSERT INTO order_items (order_id,product_id,qty,harga)
                 VALUES ('$order_id','$id','$qty','{$p['harga']}')"
            );

            mysqli_query($conn,
                "UPDATE products SET stok = stok - $qty WHERE id='$id'"
            );
        }

        unset($_SESSION['cart']);

        header("Location: ?page=success&kode=$kode&metode=" . urlencode($metode));
        exit;

    case 'success':
        require '../app/views/shop/success.php';
        break;

    case 'shop':
    default:
        require '../app/views/shop/home.php';
        break;
        

        case 'login':
            require '../app/views/auth/login.php';
            break;
        
        case 'dashboard':
            require '../app/views/admin/dashboard.php';
            break;
        
        case 'logout':
            session_destroy();
            header('Location: ?page=login');
            exit;

        case 'order-detail':
                require '../app/views/admin/order_detail.php';
                break;
            
        
}
