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


// const addWrapper = ({parrents, children, tag, tagClass}) => {

//     for (const item of document.querySelectorAll(parrents)) {
//         const currentItems = item.querySelectorAll(children);
        
//         currentItems.forEach((card) => {
//             const newTagElement = document.createElement(tag);
//             addCustomClass(newTagElement, tagClass);
//             card.parentNode.insertBefore(newTagElement, card);
//             newTagElement.appendChild(card);
//         });
//     }
// }

// addWrapper({
//     parrents: document.querySelectorAll('.category-section__wrapper'),
//     children: '.product-card',
//     tag: 'li',
//     tagClass: 'products__item'
// })