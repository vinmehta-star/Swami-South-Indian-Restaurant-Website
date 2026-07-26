var app = angular.module('swamiApp', []);

app.controller('ShopController', function($scope, $http) {
    $scope.products = [
        { id: 1,  name: 'Butter Dosa',        price: 80.00,   image: 'images/dosa-butter.jpg', badge: null },
        { id: 3,  name: 'Masala Dosa',        price: 130.00,  image: 'images/dosa-Masala.jpg', badge: null },
        { id: 12, name: 'Bahubali Thali',     price: 1250.00, image: 'images/bahubali.jpg',   badge: null },
        { id: 4,  name: 'Idli',               price: 80.00,   image: 'images/idli.jpg',        badge: null },
        { id: 6,  name: 'Rasam',              price: 95.00,   image: 'images/rasam.jpg',       badge: null },
        { id: 7,  name: 'Appam',              price: 75.00,   image: 'images/Appam.jpg',       badge: 'best-seller', badgeText: 'Best Seller' },
        { id: 8,  name: 'Swami Special Dosa', price: 95.00,   image: 'images/swami-special-dosa.jpg', badge: 'new', badgeText: 'New' },
        { id: 9,  name: 'Mendu Wada',         price: 80.00,   image: 'images/vada.jpg',        badge: null },
        { id: 11, name: 'South Indian Thali', price: 290.00,  image: 'images/thali.jpg',       badge: null }
    ];

    $scope.quantities = {}; 
    $scope.products.forEach(function(p) {
        $scope.quantities[p.id] = 1;
    });

    $scope.addToCart = function(product) {
        var qty = $scope.quantities[product.id];
        var btnId = 'btn-' + product.id;
        var btn = document.getElementById(btnId);

        var data = {
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: qty
        };

        $http.post('add_to_cart.php', data).then(function(response) {
            if (response.data.success) {
                var originalText = btn.innerText;
                btn.innerText = "Added!";
                setTimeout(function() { btn.innerText = originalText; }, 1500);
                
                setTimeout(function() {
                    if (typeof window.updateCartBadge === "function") { 
                        window.updateCartBadge(); 
                    }
                }, 200);
            } else {
                alert("Error: " + response.data.message);
            }
        });
    };
});

app.controller('CartController', function($scope, $http, $window) {
    $scope.cart = [];
    $scope.totals = { subtotal: 0, tax: 0, total: 0 };
    $scope.isLoading = true;

    
    $scope.loadCart = function() {
        $http.get('get_cart.php').then(function(response) {
            if (response.data.success) {
                $scope.cart = response.data.cart;
                $scope.totals = response.data.totals;
                
                $scope.cart.forEach(function(item) {
                    item.quantity = parseInt(item.quantity);
                });
            }
            $scope.isLoading = false;
        });
    };

    $scope.removeItem = function(id) {
        if(!confirm("Are you sure you want to remove this item?")) return;

        $http.post('update_cart.php', {
            action: 'remove_item',
            product_id: id
        }).then(function(response) {
            if (response.data.success) {
                $scope.loadCart(); 
                if (typeof window.updateCartBadge === "function") window.updateCartBadge();
            }
        });
    };

    $scope.updateQty = function(item) {
        if (item.quantity < 1) {
            item.quantity = 1;
            return;
        }

        $http.post('update_cart.php', {
            action: 'update_quantity',
            product_id: item.product_id,
            quantity: item.quantity
        }).then(function(response) {
            if (response.data.success) {
                $scope.loadCart();
                if (typeof window.updateCartBadge === "function") window.updateCartBadge();
            }
        });
    };

    $scope.checkout = function() {
        if ($scope.cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }
        $window.location.href = 'checkout.php';
    };
    $scope.loadCart();
});

app.controller('HomeController', function($scope, $http, $timeout) {
    $scope.featuredProducts = [
        { id: 1,  name: 'Butter Dosa',        price: 80.00,   image: 'images/dosa-butter.jpg', badge: null },
        { id: 3,  name: 'Masala Dosa',        price: 130.00,  image: 'images/dosa-Masala.jpg', badge: null },
        { id: 12, name: 'Bahubali Thali',     price: 1250.00, image: 'images/bahubali.jpg',   badge: null },
        { id: 4,  name: 'Idli',               price: 80.00,   image: 'images/idli.jpg',        badge: null },
        { id: 6,  name: 'Rasam',              price: 95.00,   image: 'images/rasam.jpg',       badge: null },
        { id: 7,  name: 'Appam',              price: 75.00,   image: 'images/Appam.jpg',       badge: 'best-seller', badgeText: 'Best Seller' },
        { id: 8,  name: 'Swami Special Dosa', price: 95.00,   image: 'images/swami-special-dosa.jpg', badge: 'new', badgeText: 'New' },
        { id: 9,  name: 'Mendu Wada',         price: 80.00,   image: 'images/vada.jpg',        badge: null },
        { id: 11, name: 'South Indian Thali', price: 290.00,  image: 'images/thali.jpg',       badge: null }
    ];

    $scope.quantities = {}; 
    $scope.featuredProducts.forEach(function(p) {
        $scope.quantities[p.id] = 1;
    });

    $scope.addToCart = function(product) {
        var qty = $scope.quantities[product.id];
        var btnId = 'btn-home-' + product.id; 
        var btn = document.getElementById(btnId);

        var data = {
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: qty
        };

        $http.post('add_to_cart.php', data).then(function(response) {
            if (response.data.success) {
                if(btn) {
                    var originalText = btn.innerText;
                    btn.innerText = "Added!";
                    setTimeout(function() { btn.innerText = originalText; }, 1500);
                }
                
                setTimeout(function() {
                    if (typeof window.updateCartBadge === "function") { 
                        window.updateCartBadge(); 
                    }
                }, 200);
            } else {
                alert("Error: " + response.data.message);
            }
        });
    };

    $timeout(function() {
        if (typeof window.initCarousel === "function") {
            window.initCarousel();
        }
    }, 100); 
});