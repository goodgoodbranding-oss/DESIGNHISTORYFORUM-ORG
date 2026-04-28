(function () {
	"use strict";

	var blocks = document.querySelectorAll("[data-dhf-article-tools]");

	if (!blocks.length) {
		return;
	}

	var copyText = function (text) {
		if (navigator.clipboard && navigator.clipboard.writeText) {
			return navigator.clipboard.writeText(text);
		}

		return new Promise(function (resolve, reject) {
			var field = document.createElement("textarea");
			field.value = text;
			field.setAttribute("readonly", "");
			field.style.position = "absolute";
			field.style.left = "-9999px";
			document.body.appendChild(field);
			field.select();

			try {
				document.execCommand("copy");
				document.body.removeChild(field);
				resolve();
			} catch (error) {
				document.body.removeChild(field);
				reject(error);
			}
		});
	};

	blocks.forEach(function (block) {
		var prompt = block.getAttribute("data-prompt") || "";
		var url = block.getAttribute("data-url") || window.location.href;
		var toast = block.querySelector("[data-ai-toast]");
		var toastTimer = 0;

		var showToast = function (message) {
			if (!toast) {
				return;
			}

			toast.textContent = message;
			toast.hidden = false;
			toast.classList.add("is-visible");

			window.clearTimeout(toastTimer);
			toastTimer = window.setTimeout(function () {
				toast.classList.remove("is-visible");
				toast.hidden = true;
			}, 2400);
		};

		block.querySelectorAll("[data-ai-tool]").forEach(function (link) {
			link.addEventListener("click", function () {
				var label = link.getAttribute("data-ai-label") || "AI";

				copyText(prompt)
					.then(function () {
						showToast("Prompt copied for " + label + ". Paste with Ctrl+V.");
					})
					.catch(function () {
						window.prompt("Skopiuj prompt do " + label + ":", prompt);
						showToast("Prompt ready to paste into " + label + ".");
					});
			});
		});

		var copyLinkButton = block.querySelector("[data-copy-link]");

		if (copyLinkButton) {
			copyLinkButton.addEventListener("click", function () {
				copyText(url)
					.then(function () {
						showToast("Article link copied.");
					})
					.catch(function () {
						showToast("Could not copy the article link.");
					});
			});
		}
	});
})();
