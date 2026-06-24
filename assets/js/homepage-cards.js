(function () {
	"use strict";

	var targetUrl = "https://deepbrand.ing/";
	var cards = document.querySelectorAll(
		".kb-row-layout-id340_24e797-25 .wp-block-kadence-column"
	);
	var heroArea = document.querySelector(".home .kadence-column340_933a39-2e");
	var heroHeading = heroArea
		? heroArea.querySelector(".kt-adv-heading340_2cfe6c-80")
		: null;
	var finePointer = window.matchMedia("(pointer: fine)").matches;
	var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	var heroFrame = 0;
	var heroCurrent = 100;
	var heroTarget = 100;

	// Cache the hero area dimensions to prevent layout thrashing
	// `getBoundingClientRect` inside pointermove forces synchronous layout recalculations
	var cachedRect = null;
	var updateCachedRect = function () {
		if (heroArea) {
			cachedRect = heroArea.getBoundingClientRect();
		}
	};

	var renderHeroWidth = function () {
		heroCurrent += (heroTarget - heroCurrent) * 0.16;
		heroHeading.style.setProperty("--dhf-hero-wdth", heroCurrent.toFixed(2));
		heroHeading.style.setProperty(
			"--dhf-hero-stretch",
			heroCurrent.toFixed(2) + "%"
		);

		if (Math.abs(heroTarget - heroCurrent) > 0.1) {
			heroFrame = window.requestAnimationFrame(renderHeroWidth);
			return;
		}

		heroFrame = 0;
	};

	var queueHeroWidth = function () {
		if (!heroFrame) {
			heroFrame = window.requestAnimationFrame(renderHeroWidth);
		}
	};

	var updateHeroWidth = function (clientX) {
		if (!cachedRect) return;

		var centerX = cachedRect.left + cachedRect.width / 2;
		var distance = Math.min(
			Math.abs(clientX - centerX) / (cachedRect.width / 2 || 1),
			1
		);

		heroTarget = 100 - distance * 18;
		queueHeroWidth();
	};

	if (heroArea && heroHeading && finePointer && !reduceMotion) {
		// Initialize the rect on first enter
		heroArea.addEventListener("pointerenter", function (event) {
			updateCachedRect();
			updateHeroWidth(event.clientX);
		});

		// Listen to resize and scroll to keep the cached rect accurate
		window.addEventListener("resize", updateCachedRect, { passive: true });
		window.addEventListener("scroll", updateCachedRect, { passive: true });

		heroArea.addEventListener("pointermove", function (event) {
			updateHeroWidth(event.clientX);
		});

		heroArea.addEventListener("pointerleave", function () {
			heroTarget = 100;
			queueHeroWidth();
		});
	}

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
