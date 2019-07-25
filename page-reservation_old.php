<?php include('header.php'); ?>
<div class="content clearfix">
            <div class="srodek orderOneStep">

<div class="backToOffer clearfix">
    <a href="/wczasy/hiszpania/hotel-180770-fayna---flamingo-appartements.html?oferta=dada1e4483671a263520692a7f146067ec4fef65555bca37948c7acc40efa2de" class="greyFont"><span class="sprite"></span>powrót do oferty</a>
</div>

<div class="main-content main-content--subpage">
	<div class="container">
		<div class="row">
			<?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
		</div>
	</div>
</div>

<div class="container">
		<div class="row">
                    <div class="col-md-12">
<form action="/zamowienie/krok-4/dada1e4483671a263520692a7f146067ec4fef65555bca37948c7acc40efa2de" method="post" name="reserve" id="reserve">
<input id="id-oferty" name="offer-id" value="dada1e4483671a263520692a7f146067ec4fef65555bca37948c7acc40efa2de" type="hidden">
<input name="adult_count" value="2" type="hidden">
<input name="liczbaDzieci" value="0" type="hidden">
<input name="dataDziecka1" value="17.03.2015" type="hidden">
<input name="dataDziecka2" value="17.03.2015" type="hidden">
<input name="dataDziecka3" value="17.03.2015" type="hidden">
<input name="country" value="Polska" type="hidden">
    <div class="reservationForm">
        <!--<div class="secureConnection">-->
            <!--<span class="connectionInfo">Państwa dane są bezpieczne.<br />Połączenie jest szyfrowane.</span>-->
            <!--<span class="sslInfo">Wszystkie dane są chronione certyfikatem SSL</span>-->
            <!--<div class="thawteLogo"><span class="sprite lock"></span><span class="sprite thawte"></span></div>-->
        <!--</div>-->
        <h2 class="reservationTitle">Formularz rezerwacji wstępnej</h2>
        <strong class="reservationPaymentInfo">Rezerwacja jest całkowicie bezpłatna.</strong>
        <span class="requiredInfo">* pola obowiązkowe</span>

        <h5>Podaj dane osoby rezerwującej</h5>
        <div class="validationErrorDescription"></div>
        <fieldset id="orderingPersonalData">
            <label for="ordering_gender" id="ordering_gender_label">Płeć<span class="required">*</span></label>
             <select name="gender" id="ordering_gender">
                <option value="H">Pan</option>
                <option value="F">Pani</option>
            </select>
            
            <label for="ordering_name" id="ordering_name_label">Imię<span class="required">*</span></label>
            <input name="name" id="ordering_name" data-required="true" data-error-message="Proszę podać imię osoby rezerwującej." type="text">
            
            <label for="ordering_surname" id="ordering_surname_label">Nazwisko<span class="required">*</span></label>
             <input name="lastname" id="ordering_surname" data-required="true" data-error-message="Proszę podać nazwisko osoby rezerwującej." type="text">
            
            <label for="ordering_birth_date" id="ordering_birth_date_label">Data urodzenia<span class="required">*</span></label>
            <input name="birthdate" id="ordering_birth_date" type="text"> <!-- kiedy jest wymagane a kiedy nie? -->
           
        </fieldset>
        <fieldset id="orderingAddressStreet">
            <label for="ordering_address_street">Ulica, nr domu / nr lokalu<span class="required">*</span></label>
            <input name="street" id="ordering_address_street" data-required="true" data-error-message="Proszę podać adres osoby rezerwującej." type="text">
            <span class="example">np. Wakacyjna 1/21</span>
        </fieldset>
        <fieldset id="orderingAddressCity">
            <label for="ordering_postal_code" id="ordering_postal_code_label">Kod pocztowy<span class="required">*</span></label>
             <input name="zipcode" id="ordering_postal_code" data-required="true" data-pattern="^(?:[0-9]{2}\-[0-9]{3})$" data-error-message="Proszę podać kod pocztowy osoby rezerwującej. Format: 00-000" type="text">
            
            <label for="ordering_city" id="ordering_city_label">Miejscowość<span class="required">*</span></label>
           <input name="city" id="ordering_city" data-required="true" data-error-message="Proszę podać miejscowość osoby rezerwującej." type="text">
        </fieldset>
        <fieldset id="orderingContactData">
            <label for="ordering_phone" id="ordering_phone_label">Telefon kontaktowy<span class="required">*</span><span class="sprite helper" data-helper-info="Możemy potrzebowac Państwa numeru telefonu, aby dokończyć rezerwację"></span></label>
             <input name="phone" id="ordering_phone" data-required="true" data-pattern="^(?:[\+]*[0-9]{2,3}[0-9]{9})*?(?:[0-9]{9})*?$" data-error-message="Proszę podać telefon kontaktowy do osoby rezerwującej. 9 cyfr bez kodu kraju" type="text">
           
            <label for="ordering_email" id="ordering_email_label">Adres e-mail<span class="required">*</span><span class="sprite helper" data-helper-info="Będziemy potrzebować adresu e-mail do skontaktowania się z Państwem  w sprawie rezerwacji"></span></label>
            <input name="email" id="ordering_email" data-required="true" data-pattern="[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2,6})$" data-error-message="Proszę podać poprawny adres e-mail osoby rezerwującej." type="text">
        </fieldset>
        <h5>Podaj dane uczestników wycieczki</h5>
        <fieldset class="participant dorosly">   
            <strong>Dorosły 1</strong>
    <label for="person1gender" class="participant_gender_label">Płeć<span class="required">*</span></label>
     <select id="person1gender" name="person1gender" class="participantGender">
        <option value="H" selected="selected">Pan</option>
<option value="F">Pani</option>

    </select>
    <label for="person1name" class="participant_name_label">Imię<span class="required">*</span></label>
      <input name="person1name" id="person1name" class="participantName" type="text">
    <label for="person1lastname" class="participant_surname_label">Nazwisko<span class="required">*</span></label>
     <input name="person1lastname" id="person1lastname" class="participantSurname" type="text">
    <label for="person1birthdate" class="participant_birth_date_label">Data urodzenia<span class="required">*</span></label>

    <input name="person1birthdate" id="person1birthdate" class="participantDateBirth participantAdultDateBirth" value="16.03.1988" type="text">
</fieldset>
        <fieldset class="participant dorosly">
        <strong>Dorosły 2</strong>     
    <label for="person2gender" class="participant_gender_label">Płeć<span class="required">*</span></label> 
    <select id="person2gender" name="person2gender" class="participantGender">
        <option value="H" selected="selected">Pan</option>
<option value="F">Pani</option>

    </select>
    <label for="person2name" class="participant_name_label">Imię<span class="required">*</span></label>
     <input name="person2name" id="person2name" class="participantName" type="text">
    <label for="person2lastname" class="participant_surname_label">Nazwisko<span class="required">*</span></label>
     
    <input name="person2lastname" id="person2lastname" class="participantSurname" type="text">
   
    <label for="person2birthdate" class="participant_birth_date_label">Data urodzenia<span class="required">*</span></label>
  
   <input name="person2birthdate" id="person2birthdate" class="participantDateBirth participantAdultDateBirth" value="16.03.1988" type="text">
</fieldset>
    </div>

    <div class="offerChosen">
        <div class="offerHeader">
            <strong>wybrana oferta</strong>
            <h4><span class="sprite stars-30"></span>Hotel Fayna / Flamingo Appartements</h4>
            <span class="location clearfix">Hiszpania, Lanzarote</span>
        </div>
        <img src="http://data2.merlinx.pl/NPL/winter/NPL-20233A-0.jpg" id="offerPhoto" width="240">

        <div class="offerChosenInfo">
            <span>Organizator: <span>Neckermann</span></span>
            <span>Kod oferty: 180770-NPL-20180403</span>
        </div>
        <div class="offerChosenInfo">
            <span>Typ pokoju: mieszkanie z 1 sypialnia prysznic WC balkon lub taras</span>
            <span>Wyżywienie: Bez wyżywienia (RO)</span>
            <span>
                  Paszport nie jest wymagany</span>
        </div>

        <div class="offerChosenInfo travel">
            <div class="departure">
                <span class="tripTitle">WYLOT</span>
                <strong>Warszawa - Lanzarote</strong>
                <span class="tripStarts">03.04.2018, godz 07:00</span>
                <span class="tripEnds">03.04.2018, godz 11:35</span>
            </div>
            <div class="arrival">
                <span class="tripTitle">Powrót</span>
                <strong>Lanzarote - Warszawa</strong>
                <span class="tripStarts">10.04.2018, godz 12:25</span>
                <span class="tripEnds">10.04.2018, godz 18:40</span>
            </div>
        </div>
        
        <div class="offerChosenInfo summary">
            <div class="participants">
                <div class="participantCost">
    <div class="participant">Dorosły</div>
    <div class="cost">2 258 zł</div>
</div>
<div class="participantCost">
    <div class="participant">Dorosły</div>
    <div class="cost">2 258 zł</div>
</div>

            </div>
            <div class="priceTotal">
    <span class="total">Razem</span>
    <span class="price">4 516 zł</span>
</div>
<div class="priceIncludes">
    <b>Cena zawiera:</b> przelot w dwie strony, zakwaterowanie i wyżywienie zgodne z ofertą, opiekę rezydenta, ubezpieczenie KL i NW<br>
<br>
<b>Cena nie zawiera:</b> kosztu wycieczek fakultatywnych, ubezpieczenia od rezygnacji
</div>
        </div>
    </div>

    <div class="additionalServices clearfix">
        
    </div>

    <div class="reservationOptions">
        <h5 id="reservationFinishTop">Jak chcesz dokończyć rezerwację?</h5>

        <div class="bookingCompletion">
            
            <fieldset>
                <input id="bookingCompletionPhone" name="formaPlatnosci" value="zgloszenie" checked="checked" type="radio">
                <label for="bookingCompletionPhone" class="radio sprite"></label>
                <label for="bookingCompletionPhone">Telefonicznie z konsultantem</label>

                <p>Konsultant Cititravel.pl skontaktuje się z Państwem w celu omówinia szczegółów i dogodnych form płatności.</p>
            </fieldset>
        </div>
        <hr>
        <div class="rights">
            <fieldset>
                <input name="acceptTerms" value="tak" id="termsOfUse" type="checkbox">
                <label for="termsOfUse" class="checkbox sprite"></label>
                <label for="termsOfUse"><span class="required">*</span>Oświadczam, że zapoznałam (-em) się i akceptuję <a target="_blank" href="http://merlin.merlinx.pl/conditions/NPL_conditions.pdf">Ogólne Warunki Uczestnictwa Touroperatora</a> oraz <a target="_blank" href="/informacje/regulamin">Regulamin</a> Cititravel Polska Sp. z o. o.</label>
            </fieldset>
            <fieldset>
                <input name="newsletter" value="tak" id="newsletter" type="checkbox">
                <label for="newsletter" class="checkbox sprite"></label>
                <label for="newsletter">Chcę otrzymywać Newsletter z aktualnymi ofertami i nowościami Cititravel.pl.</label>
            </fieldset>
            <p>W związku z art.23 ust.1 pkt 1 i ust.2 ustawy z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (Dz.U.Nr 133 poz. 883) oświadczam, że wyrażam zgodę na przetwarzanie przez Cititravel Polska Sp. o.o w systemach informatycznych moich danych osobowych. Mam prawo do ich późniejszego usunięcia.</p>
        </div>

        <div class="reserveButton clearfix">
            <a href="#" title="Rezerwuj" class="reserveBtn" onclick="javascript:tryReserve();return false;">Rezerwuję<span class="sprite"></span></a>
        </div>
        <div class="closingInfo">Nasz konsultant skontaktuje się z Państwem w celu potwierdzenia rezerwacji.</div>
    </div>

</form>
<div class="preloader-options-div"><span>Proszę czekać...<br>Czas oczekiwania do 10 sekund.</span></div>

</div>

<script type="text/javascript">
    (function () {
        var x = document.createElement('script');
        x.async = true;
        x.src = "//creativecdn.com/tags?type=script&id=pr_ZwmneprbPudDrFexbqoj_basketadd_hotel-180770-fayna---flamingo-appartements";
        document.getElementsByTagName('head')[0].appendChild(x);
    }());

    $(document).ready(function () {
        $('#ordering_postal_code').attr('data-pattern', '^(?:[0-9]'+'{'+'2'+'}' + '\\' + '-[0-9]'+'{'+'3'+'})$');
        $('#ordering_phone').attr('data-pattern', '^(?:['+'\\'+'+]*[0-9]'+'{'+'2,3'+'}'+'[0-9]'+'{'+'9'+'}'+')*?(?:[0-9]'+'{'+'9'+'}'+')*?$');
        $('#ordering_email').attr('data-pattern', "[a-z0-9!#$%&'*+/=?^_`"+'{'+'|'+'}'+'~-]+(?:'+'\\'+".[a-z0-9!#$%&'*+/=?^_`"+'{'+'|'+'}'+"~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?"+'\\'+'.)+(?:[a-z]'+'{'+'2,6'+'}'+')$');



    });

</script>
<script type="text/javascript">
    var goadservicesq = goadservicesq || [];
    try {
        goadservicesq.push(
                [
                    "_BASKET",
                    [
                        // pierwsza pozycja w koszyku
                        {
                            identifier: 'hotel-180770-fayna---flamingo-appartements',
                            quantity: '1'
                        },

                    ]
                ]
        );
        (function() {
            var goadservices = document.createElement('script');
            goadservices.type = 'text/javascript';
            goadservices.async = true;
            goadservices.src = '//t.goadservices.com/engine/4d698e6b-04ac-42bd-9928-d632ec61b77a';

            var id_s = document.cookie.indexOf('__goadservices=');
            if (id_s != -1) {
                id_s += 15;
                var id_e = document.cookie.indexOf(';', id_s);
                if (id_e == -1) {
                    id_e = document.cookie.length;
                }
                goadservices.src += '?id='+document.cookie.substring(id_s, id_e);
            }

            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(goadservices, s);
        })();
    } catch (e) {}
</script>


        </div> </div> </div> 

<?php include('parts/newsletter.php'); ?>

<?php include('parts/trip_directions.php'); ?>

<?php include('footer.php'); ?>