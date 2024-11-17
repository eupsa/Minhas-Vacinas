DarkReader.setFetchMethod(window.fetch);

DarkReader.enable({
  brightness: 100,
  contrast: 90,
  sepia: 10,
});

DarkReader.disable();

DarkReader.auto({
  brightness: 100,
  contrast: 90,
  sepia: 10,
});

DarkReader.auto(false);

(async () => {
  DarkReader.setFetchMethod(window.fetch);

  DarkReader.enable({
    brightness: 100,
    contrast: 90,
    sepia: 10,
  });

  const generatedCSS = await DarkReader.exportGeneratedCSS();
  console.log(generatedCSS);
})();


//Import in html 
//<script src="https://cdn.jsdelivr.net/npm/darkreader@4.9.96/darkreader.min.js"></script>
