function addToCart(event) {
    // Pega as informações do produto
    const button = event.target;
    const productId = button.getAttribute('data-id');
    const productName = button.getAttribute('data-name');
    const productPrice = parseFloat(button.getAttribute('data-price'));

    // Recupera o carrinho existente no localStorage, ou cria um carrinho vazio
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Verifica se o produto já está no carrinho
    const existingProductIndex = cart.findIndex(item => item.id == productId);
    
    if (existingProductIndex > -1) {
        // Se já estiver no carrinho, aumenta a quantidade
        cart[existingProductIndex].quantity += 1;
    } else {
        // Caso contrário, adiciona o novo produto
        cart.push({
            id: productId,
            name: productName,
            price: productPrice,
            quantity: 1
        });
    }

    // Atualiza o carrinho no localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Redireciona para o carrinho
    window.location.href = 'carrinho.html';
}
