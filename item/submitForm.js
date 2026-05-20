document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.getElementById("frg_fragments");
    const form = document.getElementById("articleForm");

    textarea.addEventListener("keydown", (event) => {
        if (event.altKey && event.key === "Enter") {
            event.preventDefault();
            form.submit();
        }
    });
});
