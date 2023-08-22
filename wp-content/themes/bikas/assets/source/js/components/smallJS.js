import {
    addCustomClass,
    toggleCustomClass,
    removeCustomClass,
    addClassInArray,
} from "../functions/customFunctions";

addClassInArray(document.querySelectorAll('.woocommerce-pagination'), 'custom-pagination')

for (const item of document.querySelectorAll('.category-section__wrapper')) {
    const currentItems = item.querySelectorAll('.product-card');

    currentItems.forEach((card) => {
        const newTagElement = document.createElement("li");
        addCustomClass(newTagElement, 'products__item');
        card.parentNode.insertBefore(newTagElement, card);
        newTagElement.appendChild(card);
    });
}

if (window.location.href.includes('cart')) {
    document.querySelector('[data-btn-modal="cart"]').style.pointerEvents = 'none';
}


window.addEventListener('DOMContentLoaded', function(){

    const row = this.document.querySelectorAll('.cart_item');

    row && row.forEach(function(item) {
        const numberInput = item.querySelector('.cart_item .qty');
        const buttonsContainer = item.querySelector('.cart_item .quantity');

        if (numberInput && buttonsContainer) {
            const increaseButton = document.createElement('button');
            increaseButton.textContent = '+';
            increaseButton.addEventListener('click', (e) => {
                e.preventDefault();
              numberInput.value = parseInt(numberInput.value) + 1;
            });
          
            const decreaseButton = document.createElement('button');
            decreaseButton.textContent = '-';
            decreaseButton.addEventListener('click', (e) => {
                e.preventDefault();
              const newValue = parseInt(numberInput.value) - 1;
              if (newValue >= parseInt(numberInput.getAttribute('min'))) {
                numberInput.value = newValue;
              }
            });
          
            buttonsContainer.appendChild(decreaseButton);
            buttonsContainer.appendChild(increaseButton);
        }
    })    
})

 
