document.addEventListener("DOMContentLoaded", function () {
    const cartItemsContainer = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const checkoutBtn = document.getElementById("checkout-btn");
    const backToShopBtn = document.getElementById("back-to-shop");

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>O carrinho está vazio.</p>";
        checkoutBtn.style.display = "none"; // Esconde o botão de checkout se o carrinho estiver vazio
        return;
    }

    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;

        const productDiv = document.createElement("div");
        productDiv.classList.add("cart-product");

        productDiv.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="product-image">
            <div class="cart-product-info">
                <h4>${item.name}</h4>
                <p>R$ ${item.price.toFixed(2)} x ${item.quantity}</p>
            </div>
            <button class="remove-item" data-id="${item.id}">Remover</button>
        `;

        cartItemsContainer.appendChild(productDiv);
    });

    cartTotal.textContent = `R$ ${total.toFixed(2)}`;

    // Botão "Finalizar Compra" leva ao checkout
    checkoutBtn.addEventListener("click", function () {
        window.location.href = "checkout.html";
    });

    // Botão "Voltar para Loja"
    backToShopBtn.addEventListener("click", function () {
        window.location.href = "index.html";
    });

    // Remover item do carrinho
    document.querySelectorAll(".remove-item").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            cart = cart.filter(item => item.id !== id);
            localStorage.setItem("cart", JSON.stringify(cart));
            location.reload();
        });
    });
});
