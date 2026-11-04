(function () {
  'use strict';

  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  var opslag = {
    lees: function (sleutel, standaard) {
      try { var w = window.localStorage.getItem(sleutel); return w ? JSON.parse(w) : standaard; } catch (e) { return standaard; }
    },
    schrijf: function (sleutel, waarde) {
      try { window.localStorage.setItem(sleutel, JSON.stringify(waarde)); } catch (e) {}
    }
  };

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
      zoekknop.classList.add('is-laden');
      zoekknop.setAttribute('aria-busy', 'true');
      $('span', zoekknop).textContent = 'Bezig';
    });

    window.addEventListener('pageshow', function () {
      zoekknop.classList.remove('is-laden');
      zoekknop.removeAttribute('aria-busy');
      $('span', zoekknop).textContent = 'Zoeken';
    });
  }

  var lijst = $('#favorieten');
  var toevoegItem = $('#toevoegen-item');
  var toevoegKnop = $('#toevoegen');
  var dialoog = $('#dialoog');
  var favFormulier = $('#favoriet-formulier');
  var favNaam = $('#fav-naam');
  var favType = $('#fav-type');
  var favEenheid = $('#fav-eenheid');
  var favFout = $('#fav-fout');
  var annuleer = $('#annuleren');

  if (lijst && toevoegItem && toevoegKnop && dialoog && favFormulier && favNaam && favType && favEenheid && favFout && annuleer) {
    var favorieten = opslag.lees('sp-favorieten', []);

    var tegelNamen = function () {
      return $$('.tegel', lijst).map(function (a) { return a.lastChild.textContent.trim().toLowerCase(); });
    };

    var verwijder = function (fav, li) {
      favorieten = favorieten.filter(function (f) { return f !== fav; });
      opslag.schrijf('sp-favorieten', favorieten);
      if (li.parentNode) li.parentNode.removeChild(li);
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
      var weg = document.createElement('button');
      weg.type = 'button';
      weg.className = 'tegel-weg';
      weg.setAttribute('aria-label', fav.naam + ' verwijderen');
      weg.textContent = '×';
      weg.addEventListener('click', function () { verwijder(fav, li); });
      li.appendChild(a);
      li.appendChild(weg);
      return li;
    };

    var toonFout = function (tekst, veld) {
      $('span', favFout).textContent = tekst;
      favFout.hidden = false;
      veld.setAttribute('aria-invalid', 'true');
      veld.focus();
    };

    var wisFout = function () {
      favFout.hidden = true;
      [favNaam, favType, favEenheid].forEach(function (v) { v.removeAttribute('aria-invalid'); });
    };

    favorieten.forEach(function (f) {
      if (tegelNamen().indexOf(f.naam.toLowerCase()) === -1) lijst.insertBefore(maakTegel(f), toevoegItem);
    });

    [favNaam, favType, favEenheid].forEach(function (v) {
      v.addEventListener('input', wisFout);
      v.addEventListener('change', wisFout);
    });

    toevoegKnop.addEventListener('click', function () {
      favFormulier.reset();
      wisFout();
      dialoog.showModal();
      favNaam.focus();
    });
    annuleer.addEventListener('click', function () { dialoog.close(); toevoegKnop.focus(); });

    favFormulier.addEventListener('submit', function (e) {
      e.preventDefault();
      var naam = favNaam.value.trim();
      var fav;

      if (naam) {
        if (!favType.value) { toonFout('Kies ook een soort divisie, commandant.', favType); return; }
        fav = { naam: naam, url: favType.value };
      } else if (favEenheid.value) {
        fav = { naam: favEenheid.options[favEenheid.selectedIndex].text, url: favEenheid.value };
      } else {
        toonFout('Geef uw divisie een naam of kies een eenheid.', favNaam);
        return;
      }

      if (tegelNamen().indexOf(fav.naam.toLowerCase()) !== -1) {
        toonFout('Deze divisie staat al op uw pagina.', naam ? favNaam : favEenheid);
        return;
      }

      favorieten.push(fav);
      opslag.schrijf('sp-favorieten', favorieten);
      var tegel = maakTegel(fav);
      lijst.insertBefore(tegel, toevoegItem);
      dialoog.close();
      toonMelding(fav.naam + ' is toegevoegd aan uw divisies.', function () { verwijder(fav, tegel); });
    });
  }
  var ingeklapt = opslag.lees('sp-ingeklapt', {});
  function zetBlok(blok, dicht, bewaar) {
    var knopBlok = $('.blok__knop', blok);
    blok.classList.toggle('is-ingeklapt', dicht);
    knopBlok.setAttribute('aria-expanded', String(!dicht));
    $('.blok__strook', blok).hidden = !dicht;
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
