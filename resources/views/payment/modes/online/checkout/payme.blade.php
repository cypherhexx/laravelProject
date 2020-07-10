<!doctype html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Example Bootstrap implementation</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.paymeservice.com/hf/v1/hostedfields.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  </head>

  <body>
    <div>&nbsp;</div>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
          <!-- CREDIT CARD FORM STARTS HERE -->
          <div class="panel panel-default credit-card-box">
            <div class="panel-body">
              <form role="form" id="checkout-form">
                <meta name="_token" content="{{ csrf_token() }}"/>
                <input type="hidden" name="invoice_id" value="{{ encrypt($invoice->id) }}">
                <div class="row">
                  <div class="col-xs-8 col-md-8">
                    <div class="form-group" id="card-number-group">
                      <label for="card-number-container" class="control-label">CARD NUMBER</label>
                      <div class="input-group input-group-lg">
                        <div id="card-number-container" class="form-control input-lg"></div>
                        <span class="input-group-addon"><i class="fa fa-credit-card" id="card-provider"></i></span>
                      </div>
                      <p id="card-number-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                  <div class="col-xs-4 col-md-4">
                    <div class="form-group" id="social-id-group">
                      <label for="social-id-container" class="control-label">SOCIAL ID</label>
                      <div id="social-id-container" class="form-control input-lg"></div>
                      <p id="social-id-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-4 col-md-4">
                    <div class="form-group" id="card-expiration-group">
                      <label for="card-expiration-container" class="control-label">EXPIRATION DATE</label>
                      <div id="card-expiration-container" class="form-control input-lg"></div>
                      <p id="card-expiration-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                  <div class="col-xs-4 col-md-4">
                    <div class="form-group" id="card-cvv-group">
                      <label for="card-cvv-container" class="control-label">CV CODE</label>
                      <div id="card-cvv-container" class="form-control input-lg"></div>
                      <p id="card-cvv-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                  <div class="col-xs-4 col-md-4">
                    <div class="form-group" id="zip-code-group">
                      <label for="zip-code-container" class="control-label">ZIP</label>
                      <div id="zip-code-container" class="form-control input-lg"></div>
                      <p id="zip-code-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-6 col-md-6">
                    <div class="form-group" id="first-name-group">
                      <label for="first-name-container" class="control-label">FIRST NAME</label>
                      <div id="first-name-container" class="form-control input-lg"></div>
                      <p id="first-name-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                  <div class="col-xs-6 col-md-6">
                    <div class="form-group" id="last-name-group">
                      <label for="last-name-container" class="control-label">LAST NAME</label>
                      <div id="last-name-container" class="form-control input-lg"></div>
                      <p id="last-name-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-6 col-md-6">
                    <div class="form-group" id="email-group">
                      <label for="email-container" class="control-label">EMAIL</label>
                      <div id="email-container" class="form-control input-lg"></div>
                      <p id="email-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                  <div class="col-xs-6 col-md-6">
                    <div class="form-group" id="phone-group">
                      <label for="phone-container" class="control-label">PHONE NUMBER</label>
                      <div id="phone-container" class="form-control input-lg"></div>
                      <p id="phone-messages" class="help-block" style="display: none;"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12">
                    <button class="subscribe btn btn-success btn-lg btn-block" id="submit-button" disabled>
                  Pay {{ $data['amount'] }} ILS
                </button>
                  </div>
                </div>

                <div class="row" style="display:none;" id="checkout-form-errors">
                  <div class="col-xs-12">
                    <p class="payment-errors"></p>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <!-- CREDIT CARD FORM ENDS HERE -->
        </div>
      </div>
    </div>

    <hr>

    <pre id="console-pre" style="display: none;"></pre>
    <script type="text/javascript">
      // HELPERS ---------------------------------------------------------------------------------

const mpl = 'MPL15937-75603EMV-MFP1VG2E-R50FQRJJ';
const amount = {!! json_encode($data) !!};
const consolePre = document.getElementById('console-pre');
const form = document.getElementById('checkout-form');
const cardProvider = document.getElementById('card-provider');

const numberGroup = document.getElementById('card-number-group');
const numberMessages = document.getElementById('card-number-messages');

const expirationGroup = document.getElementById('card-expiration-group');
const expirationMessages = document.getElementById('card-expiration-messages');

const cvcGroup = document.getElementById('card-cvv-group');
const cvcMessages = document.getElementById('card-cvv-messages');

const firstNameGroup = document.getElementById('first-name-group');
const firstNameMessages = document.getElementById('first-name-messages');

const lastNameGroup = document.getElementById('last-name-group');
const lastNameMessages = document.getElementById('last-name-messages');

const emailGroup = document.getElementById('email-group');
const emailMessages = document.getElementById('email-messages');

const phoneGroup = document.getElementById('phone-group');
const phoneMessages = document.getElementById('phone-messages');

const socialIdGroup = document.getElementById('social-id-group');
const socialIdMessages = document.getElementById('social-id-messages');

const zipCodeGroup = document.getElementById('zip-code-group');
const zipCodeMessages = document.getElementById('zip-code-messages');

// -----------------------------------------------------------------------------------------------------------------

const submitButton = document.getElementById('submit-button');
submitButton.disabled = true;

function tokenizationStarted() {
  submitButton.disabled = true;
  console.log('Tokenization started!');
}

function tokenizationFinished() {
  submitButton.disabled = false;
  console.log('Tokenization finished!');
}

function toggleValidationMessages(wrapper, ev) {
  if (ev.isValid) {
    this.style.display = 'none';
    wrapper.classList.remove('has-error');
  } else {
    this.innerText = ev.message;
    this.style.display = 'block';
    wrapper.classList.add('has-error');
  }
}

function changeCardProviderIcon(cardVendor) {

  const vendorsToClasses = {
    'unknown': ['fa', 'fa-credit-card'],

    'amex': ['fa', 'fa-cc-amex'],
    'diners': ['fa', 'fa-cc-diners-club'],
    'jcb': ['fa', 'fa-cc-jcb'],
    'visa': ['fa', 'fa-cc-visa'],
    'mastercard': ['fa', 'fa-cc-mastercard'],
    'discover': ['fa', 'fa-cc-discover'],
  };

  cardProvider.classList.remove(...cardProvider.classList);
  cardProvider.classList.add(...(vendorsToClasses[cardVendor] ? vendorsToClasses[cardVendor] : vendorsToClasses['unknown']));
}

// -----------------------------------------------------------------------------------------------------------------

const allFieldsReady = [];

PayMe.create(mpl, {
  testMode: true
}).then((instance) => {

  const fields = instance.hostedFields();

  const cardNumberSettings = {
    placeholder: 'Credit Card Number',
    messages: { invalid: 'Bad credit card number' },
    styles: {
      base: {
        'font-size': '20px',
        'text-align': 'center',
        '::placeholder': {
          color: 'blue'
        }
      },
      invalid: {
        'color': 'red'
      },
      valid: {
        'color': 'green'
      }
    }
  };
  const cardNumber = fields.create(PayMe.fields.NUMBER, cardNumberSettings);
  allFieldsReady.push(
    cardNumber.mount('#card-number-container')
  );
  cardNumber.on('card-type-changed', ev => changeCardProviderIcon(ev.cardType));
  cardNumber.on('keyup', toggleValidationMessages.bind(numberMessages, numberGroup));

  cardNumber.on('change', console.log);
  cardNumber.on('blur', console.log);
  cardNumber.on('focus', console.log);
  cardNumber.on('keyup', console.log);
  cardNumber.on('keydown', console.log);
  cardNumber.on('keypress', console.log);
  cardNumber.on('validity-changed', console.log);
  cardNumber.on('card-type-changed', console.log);

  const expiration = fields.create(PayMe.fields.EXPIRATION);
  allFieldsReady.push(
    expiration.mount('#card-expiration-container')
  );
  expiration.on('keyup', toggleValidationMessages.bind(expirationMessages, expirationGroup));
  expiration.on('validity-changed', toggleValidationMessages.bind(expirationMessages, expirationGroup));

  const cvc = fields.create(PayMe.fields.CVC);
  allFieldsReady.push(
    cvc.mount('#card-cvv-container')
  );
  cvc.on('keyup', toggleValidationMessages.bind(cvcMessages, cvcGroup));
  cvc.on('validity-changed', toggleValidationMessages.bind(cvcMessages, cvcGroup));

  const phone = fields.create(PayMe.fields.PHONE);
  allFieldsReady.push(
    phone.mount('#phone-container')
  );
  phone.on('keyup', toggleValidationMessages.bind(phoneMessages, phoneGroup));
  phone.on('validity-changed', toggleValidationMessages.bind(phoneMessages, phoneGroup));

  const email = fields.create(PayMe.fields.EMAIL);
  allFieldsReady.push(
    email.mount('#email-container')
  );
  email.on('keyup', toggleValidationMessages.bind(emailMessages, emailGroup));
  email.on('validity-changed', toggleValidationMessages.bind(emailMessages, emailGroup));

  const firstName = fields.create(PayMe.fields.NAME_FIRST);
  allFieldsReady.push(
    firstName.mount('#first-name-container')
  );
  firstName.on('keyup', toggleValidationMessages.bind(firstNameMessages, firstNameGroup));
  firstName.on('validity-changed', toggleValidationMessages.bind(firstNameMessages, firstNameGroup));

  const lastName = fields.create(PayMe.fields.NAME_LAST);
  allFieldsReady.push(
    lastName.mount('#last-name-container')
  );
  lastName.on('keyup', toggleValidationMessages.bind(lastNameMessages, lastNameGroup));
  lastName.on('validity-changed', toggleValidationMessages.bind(lastNameMessages, lastNameGroup));

  const socialId = fields.create(PayMe.fields.SOCIAL_ID);
  allFieldsReady.push(
    socialId.mount('#social-id-container')
  );
  socialId.on('keyup', toggleValidationMessages.bind(socialIdMessages, socialIdGroup));
  socialId.on('validity-changed', toggleValidationMessages.bind(socialIdMessages, socialIdGroup));
  
  const zipCode = fields.create(PayMe.fields.ZIP_CODE);
  allFieldsReady.push(
    zipCode.mount('#zip-code-container')
  );
  zipCode.on('keyup', toggleValidationMessages.bind(zipCodeMessages, zipCodeGroup));
  zipCode.on('validity-changed', toggleValidationMessages.bind(zipCodeMessages, socialIdGroup));

  Promise.all(allFieldsReady).then(() => submitButton.disabled = false);

  form.addEventListener('submit', ev => {
    ev.preventDefault();

    const sale = {

      // payerFirstName: 'Vladimir',
      // payerLastName: 'kondratiev',
      // payerEmail: 'trahomoto@mailforspam.com',
      // payerPhone: '1231231',
      // payerZipCode: '123123123',

      // payerSocialId: '65656',

      total: {
        label: 'Rubber duck',
        amount: {
          currency: 'ILS',
          value: amount.amount.toString(),
        }
      }
    };


    tokenizationStarted();

    instance.tokenize(sale)
      .then(data => {
        console.log('Tokenization result::: ', data);
        consolePre.innerText = 'Tokenization result::: \r\n';
        consolePre.innerText = consolePre.innerText + JSON.stringify(data, null, 2);
        var invoice_id = $('input[name="invoice_id"]').attr('value');
       var token = document.getElementsByName("csrfToken").value;
        $.ajax({
          type: "POST",
          url: '/microelephant_crm/crm/invoices/payment/process/payme',
          data: {
              data: data,
              invoice_id: invoice_id
          },
           headers: {
                     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               },
          success: function(res) {
           window.location=res.url;
          }
        })
        tokenizationFinished();
      })
      .catch(err => {
        console.error(err);
        console.log("error shows");
        alert(err['payload']['status_error_details'] + "... please type again");
        setTimeout("location.reload(true);", 1000);
        tokenizationFinished();
      });
  });

  // document.getElementById('tear-down').addEventListener('click', () => instance.teardown());

});

    </script>
  </body>

</html>
