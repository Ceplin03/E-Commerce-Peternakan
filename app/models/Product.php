<?php
class Product {
    public static function all($conn) {
        return mysqli_query($conn, "SELECT * FROM products");
    }
}
