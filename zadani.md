# Testovací zadání

Níže je zadání pro vytvoření jednoduché php aplikace. Prosíme o založení nějakého GIT repozitáře, kde budeme moci nahlédnout na veškerý tvůj kód spojený s tímto zadáním. Úloha to není nijak složitá a pravděpodobně by ji vygenerovala i kdejaká umělá inteligence. Nás ovšem zajímá hlavně tvůj kód, jak ho strukturuješ, jak ho formátuješ atd. I když se pravděpodobně nejedná o složitou aplikaci, očekáváme objektově orientovaný přístup.

Pokud by ti nebylo něco jasné nebo se někde zasekneš a nebudeš vědět, jak dál nebo jak na to, neboj se ozvat a na cokoli se zeptat.


## Astronomy Picture of the Day

NASA na svém webu [Astronomy Picture of the Day](http://apod.nasa.gov/apod/astropix.html) prezentuje každý den nějaký zajímavý obrázek nebo video. Kromě toho poskytuje [API](https://api.nasa.gov/), jehož endpoint `APOD` vrácí data k těmto obrázkům. Lze tak získat informace o poskytnutých obrázcích i zpětně do historie.

Tvým úkolem je vytvořit v php aplikaci, která se napojí na API a umožní uživateli získat zpětně informace z tohoto webu. Získaná data by se měla exportovat do csv souboru. Uživatele kromě URL adresy daného média zajímá také jeho název, typ (zda se jedná o obrázek, video apod.) a samozřejmě datum jeho zveřejnění.

Základem aplikace by měl být HTML formulář, kde si uživatel zvolí, za jaké období chce data získat. A to buď jako datum od/do, nebo zadáním počátečního dne a délky období (např. týden, měsíc nebo přesný počet dní). Formulář nemusí být nijak stylovaný, jde především o jeho funkčnost. Měl by ale být do značné míry "blbuvzdorný".

API limituje počet requestů, které je možné odeslat. Bylo by dobré na stránce s formulářem zobrazit informaci o tom, kolik ještě dotazů může uživatel odeslat. Hint: informaci lze získat až po prvním odeslání požadavku na API.
