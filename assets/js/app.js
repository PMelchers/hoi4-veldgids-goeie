/* Gedrag van het thema: zoeken, favorieten toevoegen en blokken inklappen. */
(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  // Opslag in de browser. Als dat niet kan, werkt alles nog steeds, alleen zonder onthouden.
  var opslag = {
    lees: function (sleutel, standaard) {
      try { var w = window.localStorage.getItem(sleutel); return w ? JSON.parse(w) : standaard; } catch (e) { return standaard; }
    },
    schrijf: function (sleutel, waarde) {
      try { window.localStorage.setItem(sleutel, JSON.stringify(waarde)); } catch (e) { /* niet erg */ }
    }
  };

  /* ---------- Meldingen met ongedaan maken ---------- */
  var meldingen = $('#meldingen');
  function toonMelding(tekst, ongedaan) {
    if (!meldingen) return;
    var toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = '<svg class="icoon" aria-hidden="true"><use href="#i-vinkje"/></svg><span></span>';
    $('span', toast).textContent = tekst;
    var timer;
    function sluit() { clearTimeout(timer); if (toast.parentNode) toast.parentNode.removeChild(toast); }
    var knop = document.createElement('button');
    knop.type = 'button';
    knop.className = 'knop knop--tekst';
    knop.textContent = 'Ongedaan maken';
    knop.addEventListener('click', function () { ongedaan(); sluit(); });
    toast.appendChild(knop);
    meldingen.appendChild(toast);
    timer = setTimeout(sluit, 7000);
  }

  /* ---------- Zoeken: foutmelding bij een leeg veld en een laadstate ---------- */
  var formulier = $('#zoekformulier');
  var veld = $('#zoekveld');
  var fout = $('#zoek-fout');
  var zoekknop = $('#zoekknop');

  if (formulier && veld && fout && zoekknop) {
    veld.addEventListener('input', function () {
      fout.hidden = true;
      veld.removeAttribute('aria-invalid');
    });

    formulier.addEventListener('submit', function (e) {
      if (!veld.value.trim()) {
        e.preventDefault();
        fout.hidden = false;
        veld.setAttribute('aria-invalid', 'true');
        veld.focus();
        return;
      }
      fout.hidden = true;
      veld.removeAttribute('aria-invalid');
      // Het formulier wordt gewoon verstuurd. Tot de nieuwe pagina er is, laat de knop zien dat er gezocht wordt.
      zoekknop.classList.add('is-laden');
      zoekknop.setAttribute('aria-busy', 'true');
      $('span', zoekknop).textContent = 'Bezig';
    });

    // Terug met de knop Vorige van de browser: de laadstate mag niet blijven staan.
    window.addEventListener('pageshow', function () {
      zoekknop.classList.remove('is-laden');
      zoekknop.removeAttribute('aria-busy');
      $('span', zoekknop).textContent = 'Zoeken';
    });
  }

  /* ---------- Favorieten: een eenheid toevoegen aan Mijn divisies ---------- */
  var lijst = $('#favorieten');
  var toevoegItem = $('#toevoegen-item');
  var toevoegKnop = $('#toevoegen');
  var dialoog = $('#dialoog');
  var favFormulier = $('#favoriet-formulier');
  var favEenheid = $('#fav-eenheid');
  var favFout = $('#fav-fout');
  var annuleer = $('#annuleren');

  if (lijst && toevoegItem && toevoegKnop && dialoog && favFormulier && favEenheid && favFout && annuleer) {
    var favorieten = opslag.lees('sp-favorieten', []);

    // Staat deze eenheid al als tegel in de lijst, bijvoorbeeld via het menu?
    var staatErAl = function (url) {
      return $$('.tegel', lijst).some(function (a) { return a.href === url; });
    };

    var maakTegel = function (fav) {
      var li = document.createElement('li');
      li.className = 'kol-2';
      var a = document.createElement('a');
      a.className = 'tegel';
      a.href = fav.url;
      var icoon = document.createElement('span');
      icoon.className = 'tegel__icoon';
      icoon.setAttribute('aria-hidden', 'true');
      icoon.textContent = fav.naam.charAt(0).toUpperCase();
      a.appendChild(icoon);
      a.appendChild(document.createTextNode(fav.naam));
      li.appendChild(a);
      return li;
    };

    var toonFout = function (tekst) {
      $('span', favFout).textContent = tekst;
      favFout.hidden = false;
      favEenheid.setAttribute('aria-invalid', 'true');
      favEenheid.focus();
    };

    favorieten.forEach(function (f) {
      if (!staatErAl(f.url)) lijst.insertBefore(maakTegel(f), toevoegItem);
    });

    favEenheid.addEventListener('change', function () {
      favFout.hidden = true;
      favEenheid.removeAttribute('aria-invalid');
    });

    toevoegKnop.addEventListener('click', function () {
      favFormulier.reset();
      favFout.hidden = true;
      favEenheid.removeAttribute('aria-invalid');
      dialoog.showModal();
      favEenheid.focus();
    });
    annuleer.addEventListener('click', function () { dialoog.close(); toevoegKnop.focus(); });

    favFormulier.addEventListener('submit', function (e) {
      e.preventDefault();
      var url = favEenheid.value;
      if (!url) { toonFout('Kies eerst een eenheid, commandant.'); return; }
      if (staatErAl(url)) { toonFout('Deze eenheid staat al bij uw divisies.'); return; }

      var naam = favEenheid.options[favEenheid.selectedIndex].text;
      var fav = { naam: naam, url: url };
      favorieten.push(fav);
      opslag.schrijf('sp-favorieten', favorieten);
      var tegel = maakTegel(fav);
      lijst.insertBefore(tegel, toevoegItem);
      dialoog.close();
      toonMelding(naam + ' is toegevoegd aan uw divisies.', function () {
        favorieten = favorieten.filter(function (f) { return f.url !== fav.url; });
        opslag.schrijf('sp-favorieten', favorieten);
        if (tegel.parentNode) tegel.parentNode.removeChild(tegel);
      });
    });
  }
  /* ---------- Blokken: soepel inklappen met een strook om ze terug te halen ---------- */
  var ingeklapt = opslag.lees('sp-ingeklapt', {});
  function zetBlok(blok, dicht, bewaar) {
    var knopBlok = $('.blok__knop', blok);
    blok.classList.toggle('is-ingeklapt', dicht);
    knopBlok.setAttribute('aria-expanded', String(!dicht));
    $('.blok__strook', blok).hidden = !dicht;
    // Verborgen inhoud mag niet meer met het toetsenbord bereikbaar zijn.
    $('.blok__binnen', blok).inert = dicht;
    if (bewaar) { ingeklapt[blok.dataset.blok] = dicht; opslag.schrijf('sp-ingeklapt', ingeklapt); }
  }
  $$('.blok').forEach(function (blok) {
    zetBlok(blok, !!ingeklapt[blok.dataset.blok], false);
    $('.blok__knop', blok).addEventListener('click', function () {
      zetBlok(blok, !blok.classList.contains('is-ingeklapt'), true);
    });
    $('[data-toon]', blok).addEventListener('click', function () {
      zetBlok(blok, false, true);
      $('.blok__knop', blok).focus();
    });
  });
}());
