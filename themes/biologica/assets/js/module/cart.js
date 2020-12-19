const sidebarCart = document.getElementById('partialCart'),
    headerCart = document.getElementById('miniCart'),
    cartTotal = document.getElementById('total-count'),
    addToCart = document.getElementById('addToCart'),
    updateCart = document.getElementById('updateCart'),
    inputProduct = document.getElementById('product-input'),
    selected = document.getElementById('selected');

callMethods();
calculateSum();
updateInput();

function updateInput() {
    if(inputProduct) {
        let products = localStorage.getItem('products') || []
        products.length > 0 ? inputProduct.value = JSON.stringify(products) : null
    }
}
//обновление корзины
if(updateCart) {
    updateCart.addEventListener('submit', function(e) {
        e.preventDefault()
        let inputs = this.getElementsByClassName('qty'),
        products = JSON.parse(localStorage.getItem('products')) || [],
        newProduct = Array.from(inputs).map(input => {
            let prefix = input.dataset
            return ({
                id: prefix.id,
                title: prefix.title,
                price: prefix.price,
                image: prefix.image,
                count: input.value,
            })
        })
        newProduct.forEach(elem => {
            if(products.find(product => product.id == elem.id)) {
                for(let product of products) {
                    if(product.id == elem.id) {
                        product.count = elem.count;
                        break;
                    }
                }
            } else {
                products.push({id: elem.id, title: elem.title, image: elem.image, price: elem.price, count: elem.count})
            }
            localStorage.setItem('products', JSON.stringify(products))
            callMethods()
        })
        changeQty();
        successMessage('Корзина обновлена!', 'info')
    })
}
//генерация сообщния добавления товара
function successMessage(text = 'Товар успешно добавлен!', alertClass = 'success') {
    let html = `<div class="alert-message">
                    <div class="alert alert-${alertClass}" data-interval="4">${text}</div>
                </div>`
    document.body.insertAdjacentHTML('afterbegin', html)
    let alert = document.querySelector('.alert-message');
    setTimeout(() => {
        alert.style.top = 0;
    }, 1500)
    setTimeout(() => {
        alert.remove();
    }, 2500)
}

//добавление товара в одиночном товаре
if(addToCart) {
    addToCart.addEventListener('submit', e => {
    e.preventDefault()
    let prefix = addToCart.qty.dataset
    setInLocalStorage(prefix.id, prefix.title, prefix.image, prefix.price, count = addToCart.qty.value)
    callMethods()
    successMessage()
    })
}
document.addEventListener('click', handleClick)
//обработка событий для покупки нового товара и его удаления
function handleClick(e) {
    const target = e.target;
    if((target.classList.contains('add-to-cart') && target.tagName.toLowerCase() == 'a')
    || (target.parentNode.classList.contains('add-to-cart') && target.parentNode.tagName.toLowerCase() == 'a' )) {
        e.preventDefault()
        addProductToCart(e)
        callMethods()
        successMessage()
    }
    else if(target.className == 'fas fa-times remove-fa') {
        e.preventDefault()
        removeProduct(e)
        callMethods()
        successMessage('Товар удален из корзины', 'primary')
    }
}
//заполнение корзины
function fillCart(position) {
    if(position) {
        let productWrap = position.querySelector('.shopping-cart-items'),
            products = JSON.parse(localStorage.getItem('products')) || [],
            buttons = position.querySelector('.buttons'),
            totalSum = position.querySelector('.cart-footer .total-sum');

        if(productWrap) {
            productWrap.innerHTML = ''
            products.length > 0
            ? pushCart(productWrap, totalSum, buttons, products, 'standart')
            : hideFooterCart(totalSum, buttons, productWrap, '<tr class="cart-item"><td colspan="6">Корзина пуста!</td></tr>')

        } else if(productWrap = position.querySelector('.cart-table tbody')) {
            productWrap.innerHTML = ''
            products.length > 0
            ? pushCart(productWrap, totalSum, buttons, products, 'cart')
            : hideFooterCart(totalSum, buttons, productWrap, '<tr class="cart-item"><td colspan="6">Корзина пуста!</td></tr>')

        } else if(productWrap = position.querySelector('.checkout-table tbody')) {
            productWrap.innerHTML = ''
            products.length > 0
            ? pushCart(productWrap, totalSum, buttons, products, 'checkout')
            : hideFooterCart(totalSum, buttons, productWrap, '<tr class="cart-item"><td colspan="2">Вы ничего не добавили в корзину!</td></tr>')

            products.length > 0
            ? document.querySelector('form .lower-box button').removeAttribute('disabled')
            : document.querySelector('form .lower-box button').setAttribute('disabled', true)
        }

    }
}
//заполнение корзины
function pushCart(...props) {
    const [productWrap, totalSum, buttons, products, type] = props //spread
    productWrap.insertAdjacentHTML('afterbegin', generateHtml(type, products))
    totalSum.textContent = calculateSum(products)
    buttons.classList.remove('d-none')
}
//скрыть подвал корзины если нет товаров
function hideFooterCart(...props) {
    const [totalSum, buttons, productWrap, text] = props //spread
    totalSum.textContent = 0
    buttons.classList.add('d-none')
    productWrap.insertAdjacentHTML('afterbegin', text)
}
//генерация html
function generateHtml(...props) {
    const [type, products] = props //spread
    let html = ''
    if(type == 'standart') {
        html = products.map(product => {
            return `<li class="cart-item">
                        <div class="media-left">
                        <div class="cart-img">
                            <img class="media-object img-responsive" src="${product.image}" alt="${product.title}">
                        </div>
                        </div>
                        <div class="media-body">
                        <h6 class="media-heading">${product.title}</h6>
                        <span class="price">${product.price} ₽</span>
                        <span class="qty">Кол-во: ${product.count}</span> </div>
                    </li>`
        }).join(' ');
    } else if(type == 'cart') {
        html = products.map(product => {
            return `<tr>
                        <th class="th-image">
                            <div class="th-image__wrapper">
                                <img class="th-image-pic" src="${product.image}" alt="${product.title}" />
                                <span class="th-image-title">${product.title}</span>
                            </div>
                        </th>
                        <td><span class="price"><small>₽</small>${product.price}</span></td>
                        <td>
                            <div class="quantity">
                            <button type="button" class="quantity-left-minus"  data-type="minus" data-field=""> <span>-</span> </button>
                                <input type="number" id="quantity" class="quantity__input qty" name="qty" min="1" max="100" step="1" value="${product.count}" data-price="${product.price}" data-image="${product.image}" data-title="${product.title}" data-id="${product.id}" />
                            <button type="button" class="quantity-right-plus" data-type="plus" data-field=""> <span>+</span> </button>
                            </div>
                        </div>
                        </td>
                        <td><span class="price">${Number(product.price) * Number(product.count)}<small>₽</small></span></td>
                        <td><a href="#"><i class="fas fa-times remove-fa" data-id="${product.id}"></i></a></td>
                    </tr>`
        }).join(' ');
    } else if(type == 'checkout') {
        html = products.map(product => {
            return `<tr class="cart-item">
                        <td class="product-name">${product.title}&nbsp;
                            <strong class="product-quantity">× ${product.count}</strong>
                        </td>
                        <td class="product-total">
                            <span class="woocommerce-Price-amount amount">${Number(product.price) * Number(product.count)}<span class="woocommerce-Price-currencySymbol">₽</span></span>
                        </td>
                    </tr>`
        }).join(' ');
    }
    return html
}
//сумма покупок
function calculateSum(products) {
    let sum = 0
    if(products) {
        products = products.map(product => {
            return Number(product.price) * Number(product.count)
        });
        sum = products.reduce((sum, current) => {
            return sum + current
        })
    }
    return sum
}
//количество товаров
function totalSum(sale = false) {
    let products = JSON.parse(localStorage.getItem('products')) || []
    let sum = 0
    if(products.length > 0) {
        sum = products.reduce((sum, product) => {
            return Number(sum) + Number(product.count)
        }, 0)

    }
    if(sale) {
        sum = Number(sum) * Number(sale);
    }
    cartTotal.innerHTML = sum
}
//удаление товара по id
function removeProduct(e) {
    e.preventDefault()
    let id = e.target.dataset.id
    let products = JSON.parse(localStorage.getItem('products'))
    products = products.filter(product => product.id !== id)
    localStorage.setItem('products', JSON.stringify(products));
    updateInput();
}
//добавление в корзину
function addProductToCart(e) {
    let prefix = e.target.dataset
    setInLocalStorage(prefix.id, prefix.title, prefix.image, prefix.price, count = 1)

}
//добавить в local storage
function setInLocalStorage(...props) {
    const [id, title, image, price, count] = props //spread
    let products = JSON.parse(localStorage.getItem('products')) || []
    if(products.find(product => product.id == id)) {
        for(let product of products) {
            if(product.id == id) {
                product.count = Number(count) + Number(product.count);
                break;
            }
        }
    } else {
        products.push({id, title, image, price, count: count})
    }
    localStorage.setItem('products', JSON.stringify(products))
}
function callMethods() {
    fillCart(sidebarCart);
    fillCart(headerCart);
    totalSum();
}

jQuery('.order-form').on('ajaxSuccess', function(event) {
    event.currentTarget.reset();
    localStorage.removeItem('products');
    callMethods();
    calculateSum();
    updateInput();
    successMessage('Заказ успешно добавлен!');
});
//купон на скидку

window.addEventListener('DOMContentLoaded', () => {
    changeQty();
})

//qty
function changeQty() {
    const quantity = document.querySelectorAll('.quantity');
    if(quantity) {
        quantity.forEach(qty => {
            qty.addEventListener('click', quantityHandle)
        })
    }
    function quantityHandle(e) {
        const target = e.target;
        checkQtyHanlde(target, 'quantity-right-plus');
        checkQtyHanlde(target, 'quantity-left-minus', 'minus');
    }

    function checkQtyHanlde(target, selector, operation = 'sum') {
        if(target.classList.contains(selector) || target.parentNode.classList.contains(selector)) {
            let qty = target.closest('.quantity');
            let input = qty.querySelector('.quantity__input');
            if(operation == 'sum') {
                if(Number(input.value) < 100) {
                    input.value = Number(input.value) + 1;
                }
            } else {
                if(Number(input.value) > 1) {
                    input.value = Number(input.value) - 1;
                }
            }

        }
    }
}
//select field
if(selected) {
    const product = document.querySelector('.single-product'),
        quantity = document.getElementById('quantity'),
        submitButton = product.querySelector('.add-to-cart');

    localStorage.setItem('product', JSON.stringify({
        title: quantity.dataset.title,
        image: quantity.dataset.image,
        id: quantity.dataset.id,
        price: quantity.dataset.price
    }))

    selected.addEventListener('change', e => {
        const target= e.target
        if(target.value === 'null') {
            submitButton.setAttribute('disabled', true);
            const productStorage = JSON.parse(localStorage.getItem('product')) || [];
            setProduct(product, quantity, productStorage.title, productStorage.image, productStorage.price, productStorage.id);

        } else {
            const select = target.options[target.selectedIndex],
                  selectedImageSrc = select.dataset.image,
                  selectedTitle = select.value,
                  selectedId = select.dataset.id,
                  selectedPrice = select.dataset.price;

            setProduct(product, quantity, selectedTitle, selectedImageSrc, selectedPrice, selectedId);
            submitButton.removeAttribute('disabled');
        }
    })
}
//reset

function setProduct(product, quantity, title, imageSrc, price, productId) {

    product.querySelector('.subtitle').textContent = title;
    product.querySelector('.single-product__pic img').src = imageSrc;
    product.querySelector('.single-product__content__price span').textContent = price;

    quantity.dataset.image = imageSrc;
    quantity.dataset.price = price;
    quantity.dataset.id = productId;
    quantity.dataset.title = title;
}


