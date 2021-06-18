<x-app-layout>
    <div id="smart-button-container">
        <div style="text-align: center;">
            <div style="margin-bottom: 1.25rem;">
                <p></p>
                <select id="item-options"><option value="opcja 1" price="50">opcja 1 - 50 PLN</option><option value="opcja 2 " price="55">opcja 2  - 55 PLN</option><option value="opcja 3" price="500">opcja 3 - 500 PLN</option><option value="opcja 5" price="12">opcja 5 - 12 PLN</option></select>
                <select style="visibility: hidden" id="quantitySelect"></select>
            </div>
            <div id="paypal-button-container"></div>
        </div>
    </div>
    <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=PLN" data-sdk-integration-source="button-factory"></script>
    <script>
        function initPayPalButton() {
            var shipping = 0;
            var itemOptions = document.querySelector("#smart-button-container #item-options");
            var quantity = parseInt();
            var quantitySelect = document.querySelector("#smart-button-container #quantitySelect");
            if (!isNaN(quantity)) {
                quantitySelect.style.visibility = "visible";
            }
            var orderDescription = '';
            if(orderDescription === '') {
                orderDescription = 'Item';
            }
            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'black',
                    layout: 'horizontal',
                    label: 'pay',

                },
                createOrder: function(data, actions) {
                    var selectedItemDescription = itemOptions.options[itemOptions.selectedIndex].value;
                    var selectedItemPrice = parseFloat(itemOptions.options[itemOptions.selectedIndex].getAttribute("price"));
                    var tax = (0 === 0) ? 0 : (selectedItemPrice * (parseFloat(0)/100));
                    if(quantitySelect.options.length > 0) {
                        quantity = parseInt(quantitySelect.options[quantitySelect.selectedIndex].value);
                    } else {
                        quantity = 1;
                    }

                    tax *= quantity;
                    tax = Math.round(tax * 100) / 100;
                    var priceTotal = quantity * selectedItemPrice + parseFloat(shipping) + tax;
                    priceTotal = Math.round(priceTotal * 100) / 100;
                    var itemTotalValue = Math.round((selectedItemPrice * quantity) * 100) / 100;

                    return actions.order.create({
                        purchase_units: [{
                            description: orderDescription,
                            amount: {
                                currency_code: 'PLN',
                                value: priceTotal,
                                breakdown: {
                                    item_total: {
                                        currency_code: 'PLN',
                                        value: itemTotalValue,
                                    },
                                    shipping: {
                                        currency_code: 'PLN',
                                        value: shipping,
                                    },
                                    tax_total: {
                                        currency_code: 'PLN',
                                        value: tax,
                                    }
                                }
                            },
                            items: [{
                                name: selectedItemDescription,
                                unit_amount: {
                                    currency_code: 'PLN',
                                    value: selectedItemPrice,
                                },
                                quantity: quantity
                            }]
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Transaction completed by ' + details.payer.name.given_name + '!');
                    });
                },
                onError: function(err) {
                    console.log(err);
                },
            }).render('#paypal-button-container');
        }
        initPayPalButton();
    </script>
</x-app-layout>
