(function () {
	"use strict";

	var targetUrl = "https://deepbrand.ing/";
	var cards = document.querySelectorAll(
		".kb-row-layout-id340_24e797-25 .wp-block-kadence-column"
	);

	if (!cards.length) {
		return;
	}

	var goToTarget = function () {
		window.location.href = targetUrl;
	};

	cards.forEach(function (card) {
		card.classList.add("dhf-clickable-card");
		card.setAttribute("role", "link");
		card.setAttribute("tabindex", "0");
		card.setAttribute("aria-label", "Open deepbrand.ing");

		card.addEventListener("mouseenter", function () {
			card.classList.add("is-hovered");
		});

		card.addEventListener("mouseleave", function () {
			card.classList.remove("is-hovered", "is-pressed");
		});

		card.addEventListener("mousedown", function () {
			card.classList.add("is-pressed");
		});

		card.addEventListener("mouseup", function () {
			card.classList.remove("is-pressed");
		});

		card.addEventListener("click", goToTarget);

		card.addEventListener("keydown", function (event) {
			if (event.key === "Enter" || event.key === " ") {
				event.preventDefault();
				goToTarget();
			}
		});
	});
})();
