<?php
session_start();
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $product) {
        echo "<p>{$product['name']} - R$ {$product['price']} x {$product['quantity']}</p>";
    }
    echo "<h3>Total: R$ " . getCartTotal() . "</h3>";
} else {
    echo "<p>Seu carrinho está vazio.</p>";
}
?>
