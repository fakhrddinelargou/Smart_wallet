 document.querySelectorAll(".actions").forEach(action => {
  const dots = action.querySelector(".dots");
  const menu = action.querySelector(".menu");

  dots.addEventListener("click", (e) => {
    e.stopPropagation();
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  });


  document.addEventListener("click", () => {
    menu.style.display = "none";
  });
});

  const card = document.getElementById("successCard");
  if(card){
    setTimeout(() => {
      card.style.display = "none";
    }, 2500);  
  }