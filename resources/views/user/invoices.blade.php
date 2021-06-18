<x-app-layout>
    <script>
        $(document).ready(function() {
            $('#table').DataTable( {
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Polish.json'
                }
            } );
        } );
    </script>
    <header class="masthead bg-primary text-white text-center">
        <h1 class="masthead-heading mb-0">MOJE FAKTURY</h1>
    </header>
    <section class="page-section portfolio">
        <div class="container">
            <div class="row justify-content-center">
                <table class="table table-bordered" id="table">
                    <thead>
                    <tr>
                        <th scope="col">Numer faktury</th>
                        <th scope="col">Numer umowy</th>
                        <th scope="col">Firma</th>
                        <th scope="col">Usługa</th>
                        <th scope="col">Kwota</th>
                        <th scope="col">Opłacona</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col">Pobierz</th>
{{--                        <th scope="col">Opłać</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <th>{{ $invoice->number }}</th>
                            <th>{{ $invoice->agreement }}</th>
                            <td>{{ $invoice->company }}</td>
                            <td>{{ $invoice->service }}</td>
                            <td>{{ $invoice->price }}zł</td>
                            <td>
                                @if($invoice->confirm==0)
                                    {{'NIE'}}
                                @else
                                    {{'TAK'}}
                                @endif
                            </td>
                            <td>{{ $invoice->created_at }}</td>
                            <td>
                                <form action="{{ route('pobierz_fakture') }}">
                                    <input type="hidden" name="invoice" value="{{ $invoice->id }}">
                                    <button type="submit" class="btn btn-warning sm">POBIERZ</button>
                                </form>

                            </td>
{{--                            <td>--}}
{{--                                @if($invoice->confirm==0)--}}
{{--                                    <div id="smart-button-container">--}}
{{--                                        <div style="text-align: center"><label for="description"> </label><input type="text" name="descriptionInput" id="description" maxlength="127" value="Faktura nr {{ $invoice->number }}"></div>--}}
{{--                                        <p id="descriptionError" style="visibility: hidden; color:red; text-align: center;">Please enter a description</p>--}}
{{--                                        <div style="text-align: center"><label for="amount"> </label><input name="amountInput" type="number" id="amount" value="{{ $invoice->price }}" ><span> PLN</span></div>--}}
{{--                                        <p id="priceLabelError" style="visibility: hidden; color:red; text-align: center;">Please enter a price</p>--}}
{{--                                        <div id="invoiceidDiv" style="text-align: center; display: none;"><label for="invoiceid"> </label><input name="invoiceid" maxlength="127" type="text" id="invoiceid" value="" ></div>--}}
{{--                                        <p id="invoiceidError" style="visibility: hidden; color:red; text-align: center;">Please enter an Invoice ID</p>--}}
{{--                                        <div style="text-align: center; margin-top: 0.625rem;" id="paypal-button-container"></div>--}}
{{--                                    </div>--}}
{{--                                    <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=PLN" data-sdk-integration-source="button-factory"></script>--}}
{{--                                    <script>--}}
{{--                                        function initPayPalButton() {--}}
{{--                                            var description = document.querySelector('#smart-button-container #description');--}}
{{--                                            var amount = document.querySelector('#smart-button-container #amount');--}}
{{--                                            var descriptionError = document.querySelector('#smart-button-container #descriptionError');--}}
{{--                                            var priceError = document.querySelector('#smart-button-container #priceLabelError');--}}
{{--                                            var invoiceid = document.querySelector('#smart-button-container #invoiceid');--}}
{{--                                            var invoiceidError = document.querySelector('#smart-button-container #invoiceidError');--}}
{{--                                            var invoiceidDiv = document.querySelector('#smart-button-container #invoiceidDiv');--}}

{{--                                            var elArr = [description, amount];--}}

{{--                                            if (invoiceidDiv.firstChild.innerHTML.length > 1) {--}}
{{--                                                invoiceidDiv.style.display = "block";--}}
{{--                                            }--}}

{{--                                            var purchase_units = [];--}}
{{--                                            purchase_units[0] = {};--}}
{{--                                            purchase_units[0].amount = {};--}}

{{--                                            function validate(event) {--}}
{{--                                                return event.value.length > 0;--}}
{{--                                            }--}}

{{--                                            paypal.Buttons({--}}
{{--                                                style: {--}}
{{--                                                    color: 'gold',--}}
{{--                                                    shape: 'pill',--}}
{{--                                                    label: 'pay',--}}
{{--                                                    layout: 'horizontal',--}}

{{--                                                },--}}

{{--                                                onClick: function () {--}}
{{--                                                    if (description.value.length < 1) {--}}
{{--                                                        descriptionError.style.visibility = "visible";--}}
{{--                                                    } else {--}}
{{--                                                        descriptionError.style.visibility = "hidden";--}}
{{--                                                    }--}}

{{--                                                    if (amount.value.length < 1) {--}}
{{--                                                        priceError.style.visibility = "visible";--}}
{{--                                                    } else {--}}
{{--                                                        priceError.style.visibility = "hidden";--}}
{{--                                                    }--}}

{{--                                                    if (invoiceid.value.length < 1 && invoiceidDiv.style.display === "block") {--}}
{{--                                                        invoiceidError.style.visibility = "visible";--}}
{{--                                                    } else {--}}
{{--                                                        invoiceidError.style.visibility = "hidden";--}}
{{--                                                    }--}}

{{--                                                    purchase_units[0].description = description.value;--}}
{{--                                                    purchase_units[0].amount.value = amount.value;--}}

{{--                                                    if(invoiceid.value !== '') {--}}
{{--                                                        purchase_units[0].invoice_id = invoiceid.value;--}}
{{--                                                    }--}}
{{--                                                },--}}

{{--                                                createOrder: function (data, actions) {--}}
{{--                                                    return actions.order.create({--}}
{{--                                                        purchase_units: purchase_units,--}}
{{--                                                    });--}}
{{--                                                },--}}

{{--                                                onApprove: function (data, actions) {--}}
{{--                                                    return actions.order.capture().then(function (details) {--}}
{{--                                                        alert('Faktura została opłacona!');--}}
{{--                                                    });--}}
{{--                                                },--}}

{{--                                                onError: function (err) {--}}
{{--                                                    console.log(err);--}}
{{--                                                }--}}
{{--                                            }).render('#paypal-button-container');--}}
{{--                                        }--}}
{{--                                        initPayPalButton();--}}
{{--                                    </script>--}}
{{--                                @endif--}}
{{--                            </td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div id="smart-button-container">
                    <div style="text-align: center;">
                        <div style="margin-bottom: 1.25rem;">
                            <h3>Opłać fakturę</h3>
                            <p>Wybierz fakturę, którą chcesz opłacić</p>
                            <select id="item-options">
                                @foreach($invoices as $invoice)
                                    <option value="Faktura nr. {{ $invoice->number }}" price="{{ $invoice->price }}">Faktura nr. {{ $invoice->number }} - {{ $invoice->price }} zł</option>
                                @endforeach
                            </select>
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
                                    alert("Transakcja zakończona pomyślnie, status faktury zostanie zmieniony w chwili zaksięgowania kwoty przez firmę");
                                });
                            },
                            onError: function(err) {
                                console.log(err);
                            },
                        }).render('#paypal-button-container');
                    }
                    initPayPalButton();
                </script>
            </div>
        </div>
    </section>
</x-app-layout>
