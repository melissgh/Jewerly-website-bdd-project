function redirectToItemPage(articleUrl) {
  window.location.href = articleUrl;
}

// document.addEventListener('DOMContentLoaded', function () {
//     var likeButtons = document.querySelectorAll('.likebtn');

//     likeButtons.forEach(function (button) {
//         button.addEventListener('click', function (event) {
//             // Stop event propagation to prevent the div click
//             event.stopPropagation();

//             // Toggle the 'liked' class on button click
//             this.classList.toggle('liked');

//             // Change the heart icon based on the 'liked' state
//             var heartIcon = this.querySelector('i.fa-heart');
//             if (this.classList.contains('liked')) {
//                 heartIcon.classList.replace('fa-regular', 'fa-solid');
//             } else {
//                 heartIcon.classList.replace('fa-solid', 'fa-regular');
//             }

//             // You can also perform additional actions here, such as updating a like count or sending a request to the server.
//         });
//     });
// });

let carts = document.querySelectorAll(".fa-cart-shopping");
let cartsBtn = document.querySelectorAll(".articlebtnBag");

function addToCart(articleId, userId) {
  let articleElement = document.querySelector(`[data-id="${articleId}"]`);
  let id = articleElement.getAttribute("data-id");
  userId = articleElement.getAttribute("data-user-id");
  let name = articleElement.getAttribute("data-name");
  let img = articleElement.getAttribute("data-image");
  let priceString = articleElement.getAttribute("data-price");

  // Convertissez la chaîne de caractères du prix en nombre
  let price = parseFloat(priceString);

  // Vérifiez si la conversion est réussie (le prix est un nombre)
  if (!isNaN(price)) {
    // Appelez les fonctions nécessaires avec les informations extraites
    cartNumbers({ img, name, price, inCart: 0, id, userId });
    totalCost({ img: id, name, price, inCart: 0, id, userId });

    // ... Ajoutez d'autres fonctions si nécessaire

    // Mettez à jour l'affichage du panier
    displayCart();
  } else {
    console.error("Erreur de conversion du prix en nombre.");
  }
}

for (let i = 0; i < carts.length; i++) {
  carts[i].addEventListener("click", () => {
    // console.log('added to cart')

    let articleElement = carts[i].closest(".shopArticles");

    // Extract information from the article

    let imgElement = document.querySelector(".NewArrivalArticleImg img");
    let img = imgElement.getAttribute("data-img");
    let name = articleElement.querySelector(
      ".NewArrivalArticleName p"
    ).textContent;
    let price = parseFloat(
      articleElement.querySelector(".plusinfo p").textContent
    );

    // Call functions with extracted information
    /* cartNumbers({ tag, name, price, inCart: 0 });
      totalCost({ tag, name, price, inCart: 0 }); */

    // Ajoutez également la récupération de l'ID de l'article
    let articleId = articleElement
      .querySelector(".articlebtnBag")
      .getAttribute("data-id");
    // Appelez les fonctions avec les informations extraites et l'ID de l'article

    let userId = articleElement
      .querySelector(".articlebtnBag")
      .getAttribute("data-id-clien");

    cartNumbers({ img, name, price, inCart: 0, id: articleId, userId: userId });
    totalCost({ img, name, price, inCart: 0, id: articleId, userId: userId });

    /* cartNumbers(clickedProduct);
      totalCost(clickedProduct); 
*/
  });
}

function onLoadCartNumbers() {
  let productNumbers = localStorage.getItem("cartNumbers");

  document.querySelector(".cart span").textContent = productNumbers;
}

function cartNumbers(product) {
  // console.log("the product clicked is: ", product)

  let productNumbers = localStorage.getItem("cartNumbers");
  productNumbers = parseInt(productNumbers);
  if (productNumbers) {
    localStorage.setItem("cartNumbers", productNumbers + 1);
    document.querySelector(".cart span").textContent = productNumbers + 1;
  } else {
    localStorage.setItem("cartNumbers", +1);
    document.querySelector(".cart span").textContent = 1;
  }

  //setItems(product);
  setItems({ ...product, id: product.id, inCart: 1, userId: product.userId });
}

function setItems(product) {
  let cartItems = localStorage.getItem("productsInCart");
  cartItems = JSON.parse(cartItems);

  if (cartItems != null) {
    if (cartItems[product.id] == undefined) {
      cartItems = {
        ...cartItems,
        [product.id]: product,
      };
    } else {
      console.log(
        "Item already in the cart. Incrementing quantity. Item ID:",
        product.id
      );
      // Si l'article existe déjà dans le panier, incrémentez simplement la quantité
      cartItems[product.id].inCart += 1;
    }
  } else {
    product.inCart = 1;

    cartItems = {
      [product.id]: product,
    };
  }

  localStorage.setItem("productsInCart", JSON.stringify(cartItems));
}

function totalCost(product) {
  //console.log('product total is:', product.price);

  let cartCost = localStorage.getItem("totalCost");

  if (cartCost != null) {
    cartCost = parseInt(cartCost);
    localStorage.setItem("totalCost", cartCost + product.price);
  } else {
    localStorage.setItem("totalCost", product.price);
  }
}

function displayCart() {
  let cartItems = localStorage.getItem("productsInCart");
  cartItems = JSON.parse(cartItems);

  let productsContainer = document.querySelector(".products");

  let cartCost = localStorage.getItem("totalCost");

  /* console.log('function start')
  console.log('productsContainer:', productsContainer); */
  if (cartItems && productsContainer) {
    console.log("hellooo");

    productsContainer.innerHTML = "";
    Object.values(cartItems).map((item) => {
      productsContainer.innerHTML += `
          <div class="product" data-id="${item.id}">
          <div class="productsInfos">
              <i class="closeIcon fa-solid fa-x closeIconPanier" onclick="removeProduct('${
                item.id
              }')"></i>
              <img class="products-img" src="../../admin/php/uploads/${
                item.img
              }" alt="">
              <span>${item.name}</span>
          </div>

          <div class="productsPrice">
              <span>${item.price}DA</span>
          </div>

          <div class="productsQuantity">
              <i class="fa-solid fa-minus" onclick="decrementQuantity('${
                item.id
              }')"></i>
              <span>${item.inCart}</span>
              <i class="fa-solid fa-plus" onclick="incrementQuantity('${
                item.id
              }')"></i>
          </div>

          <div class="productsTotal">
              <span>${item.inCart * item.price}DA</span>
          </div>
      </div>`;
    });

    productsContainer.innerHTML += `
      
      <div class="basketTotalContainer">
      <h3 class="basketToalTitle">Total Price</h3>
      <h3 class="basketToal">${cartCost},00 DA</h3>
      </div>

      `;
  } else {
    productsContainer.innerHTML += `
      
      <div class="CartEmpty">
      <h3 class="CartEmptyTitle">Your Cart is Empty</h3>
      </div>
      `;

    let checkOutBtn = document.querySelector(".cartCheckOutBtn");
    checkOutBtn.style.display = "none";
  }

  //console.log('function end')
}

function incrementQuantity(itemId) {
  let cartItems = localStorage.getItem("productsInCart");
  cartItems = JSON.parse(cartItems);

  cartItems[itemId].inCart++;

  localStorage.setItem("productsInCart", JSON.stringify(cartItems));

  let cartNumbers = parseInt(localStorage.getItem("cartNumbers") || 0);
  cartNumbers++;
  localStorage.setItem("cartNumbers", cartNumbers);
  onLoadCartNumbers();

  updateTotal();

  // Rafraîchir l'affichage du panier
  displayCart();
}

// Function to decrement the quantity
function decrementQuantity(itemId) {
  let cartItems = localStorage.getItem("productsInCart");
  cartItems = JSON.parse(cartItems);

  if (cartItems[itemId].inCart > 1) {
    cartItems[itemId].inCart--;

    localStorage.setItem("productsInCart", JSON.stringify(cartItems));

    let cartNumbers = parseInt(localStorage.getItem("cartNumbers") || 0);
    cartNumbers--;
    localStorage.setItem("cartNumbers", cartNumbers);

    onLoadCartNumbers();
    updateTotal();

    // Refresh the cart display
    displayCart();
  }
}

function updateTotal() {
  let cartItems = localStorage.getItem("productsInCart");
  cartItems = JSON.parse(cartItems);

  let total = 0;

  if (cartItems) {
    Object.values(cartItems).forEach((item) => {
      total += item.inCart * item.price;
    });
  }

  localStorage.setItem("totalCost", total);
}

function removeProduct(itemId) {
  let cartItems = localStorage.getItem("productsInCart");
  cartItems = JSON.parse(cartItems);

  let removedQuantity = cartItems[itemId].inCart; // Get the quantity of the removed product

  delete cartItems[itemId];

  // Update the total and save changes to localStorage
  updateTotal();

  localStorage.setItem("productsInCart", JSON.stringify(cartItems));

  let cartNumbers = localStorage.getItem("cartNumbers");
  cartNumbers = parseInt(cartNumbers); // Convert to number
  cartNumbers =
    cartNumbers >= removedQuantity ? cartNumbers - removedQuantity : 0; // Subtract the quantity

  localStorage.setItem("cartNumbers", cartNumbers);

  updateTotal();

  // Refresh the cart display
  displayCart();

  if (Object.keys(cartItems).length === 0) {
    // Cart is empty
    let productsContainer = document.querySelector(".products");
    productsContainer.innerHTML = `
          <div class="CartEmpty">
              <h3 class="CartEmptyTitle">Your Cart is Empty</h3>
          </div>`;

    let checkOutBtn = document.querySelector(".cartCheckOutBtn");
    checkOutBtn.style.display = "none";
    updateTotal();
  }

  onLoadCartNumbers();
}

onLoadCartNumbers();
displayCart();

document.addEventListener("DOMContentLoaded", function () {
  var checkoutButton = document.getElementById("checkoutButton");

  if (checkoutButton) {
    checkoutButton.addEventListener("click", function () {
      var userId = checkoutButton.getAttribute("data-user-id");
      var cartItems = localStorage.getItem("productsInCart");

      if (userId) {
        var confirmation = confirm(
          "Are you sure you want to confirm your order?"
        );
        if (confirmation) {
          if (cartItems) {
            var parsedCartItems = JSON.parse(cartItems);
            var articleIds = Object.keys(parsedCartItems); // Obtenir les IDs des articles du panier
            envoyerPanierAuBackend(parsedCartItems, userId, articleIds);
            localStorage.clear();
            setTimeout(function () {
              displayCart();
            }, 100);
          }
          passerCommande(userId);
        } else {
          alert("Order not confirmed.");
        }
      } else {
        alert("You have to log in before placing an order.");
        localStorage.removeItem("productsInCart");
        localStorage.clear();
        displayCart();
      }
    });
  }

  function passerCommande(userId) {
    console.log("Order placed for the user with ID: " + userId);
  }

  function envoyerPanierAuBackend(cartItems, userId, articleIds) {
    console.log(
      "Sending order information to backend for user with ID: " + userId
    );

    var orderData = {
      userId: userId,
      articles: Object.keys(cartItems).map((articleId) => ({
        articleId: articleId,
        quantity: cartItems[articleId].inCart,
      })),
      clickDate: new Date().toISOString(),
    };

    console.log("Order data:", orderData);

    // Utilisez la fonction fetch pour effectuer une requête HTTP
    fetch("commande.php", {
      // Spécifiez la méthode de la requête (dans ce cas, POST)
      method: "POST",
      // Définissez les en-têtes de la requête pour indiquer le type de contenu
      headers: {
        "Content-Type": "application/json",
      },
      // Convertissez l'objet orderData en chaîne JSON et utilisez-le comme corps de la requête
      body: JSON.stringify(orderData),
    })
      // Une fois la requête terminée, analysez la réponse JSON
      .then((response) => response.json())
      // Traitez les données de la réponse
      .then((data) => {
        console.log("Response from backend:", data);
        window.location.href = "validercom.php";
      })
      // Gérez les erreurs potentielles lors de l'envoi de la requête
      .catch((error) => {
        console.error("Error sending order information to backend:", error);
      });
  }

  function displayCart() {
    console.log("Updating cart display...");
  }
});
