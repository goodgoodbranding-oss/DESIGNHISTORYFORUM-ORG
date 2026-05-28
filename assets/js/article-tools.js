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
		var modal = block.querySelector("[data-ai-modal]");
		var modalTitle = modal ? modal.querySelector("[data-ai-modal-title]") : null;
		var modalToolNames = modal
			? modal.querySelectorAll("[data-ai-modal-tool-name]")
			: [];
		var modalOpenButton = modal ? modal.querySelector("[data-ai-modal-open]") : null;
		var modalCopyButton = modal ? modal.querySelector("[data-ai-modal-copy]") : null;
		var modalCloseButtons = modal
			? modal.querySelectorAll("[data-ai-modal-close]")
			: [];
		var toastTimer = 0;
		var activeModalTool = null;

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

		var closeModal = function () {
			if (!modal) {
				return;
			}

			modal.hidden = true;
			document.body.classList.remove("dhf-ai-modal-open");
			activeModalTool = null;
		};

		var openModal = function (tool) {
			if (!modal) {
				return;
			}

			activeModalTool = tool;

			if (modalTitle) {
				modalTitle.textContent = "Finish in " + tool.label;
			}

			modalToolNames.forEach(function (node) {
				node.textContent = tool.label;
			});

			modal.hidden = false;
			document.body.classList.add("dhf-ai-modal-open");
		};

		var copyPromptForTool = function (tool, onFailure) {
			copyText(prompt)
				.then(function () {
					showToast(tool.copyNotice);
				})
				.catch(function () {
					window.prompt("Copy the prompt into " + tool.label + ":", prompt);
					showToast("Prompt ready to paste into " + tool.label + ".");

					if (typeof onFailure === "function") {
						onFailure();
					}
				});
		};

		if (modalOpenButton) {
			modalOpenButton.addEventListener("click", function () {
				if (!activeModalTool) {
					return;
				}

				window.open(activeModalTool.url, "_blank", "noopener");
				closeModal();
			});
		}

		if (modalCopyButton) {
			modalCopyButton.addEventListener("click", function () {
				if (!activeModalTool) {
					return;
				}

				copyPromptForTool(activeModalTool);
			});
		}

		modalCloseButtons.forEach(function (button) {
			button.addEventListener("click", closeModal);
		});

		document.addEventListener("keydown", function (event) {
			if (event.key === "Escape" && modal && !modal.hidden) {
				closeModal();
			}
		});

		block.querySelectorAll("[data-ai-tool]").forEach(function (link) {
			link.addEventListener("click", function (event) {
				var label = link.getAttribute("data-ai-label") || "AI";
				var launchMode = link.getAttribute("data-ai-launch-mode") || "prefill";
				var copyNotice =
					link.getAttribute("data-ai-copy-notice") ||
					"Prompt copied for " + label + ". Paste with Ctrl+V.";
				var toolConfig = {
					copyNotice: copyNotice,
					label: label,
					url: link.href,
				};

				if (launchMode === "clipboard_modal") {
					event.preventDefault();
					copyPromptForTool(toolConfig);
					openModal(toolConfig);
					return;
				}

				copyText(prompt)
					.then(function () {
						showToast(copyNotice);
					})
					.catch(function () {
						window.prompt("Copy the prompt into " + label + ":", prompt);
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
