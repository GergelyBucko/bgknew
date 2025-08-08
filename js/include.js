document.addEventListener("DOMContentLoaded", () => {
  const includes = document.querySelectorAll('[data-include]');

  includes.forEach(async (el) => {
    const file = el.getAttribute('data-include');
    try {
      const res = await fetch(file);
      if (res.ok) {
        const html = await res.text();
        el.innerHTML = html;

        const scripts = el.querySelectorAll("script");
        scripts.forEach(oldScript => {
          const newScript = document.createElement("script");
          if (oldScript.src) {
            newScript.src = oldScript.src;
          } else {
            newScript.textContent = oldScript.textContent;
          }
          document.body.appendChild(newScript);
        });

      } else {
        console.error("Include failed:", file);
      }
    } catch (err) {
      console.error(err);
    }
  });
});

