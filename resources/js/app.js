import Alpine from "alpinejs";
import html2canvas from "html2canvas";

window.Alpine = Alpine;

window.themeToggle = () => ({
    dark: false,

    init() {
        this.dark = document.documentElement.classList.contains("dark");
    },

    toggle() {
        this.dark = !this.dark;

        document.documentElement.classList.toggle("dark", this.dark);

        localStorage.setItem("theme", this.dark ? "dark" : "light");
    },
});

Alpine.start();

window.downloadMemberCard = async function (format) {
    const card = document.getElementById("member-card");

    if (!card) {
        console.error("Member card element not found.");
        return;
    }

    try {
        const images = [...card.querySelectorAll("img")];

        await Promise.all(
            images.map((image) => {
                if (image.complete) {
                    return Promise.resolve();
                }

                return new Promise((resolve) => {
                    image.addEventListener("load", resolve, { once: true });
                    image.addEventListener("error", resolve, { once: true });
                });
            }),
        );

        const canvas = await html2canvas(card, {
            scale: 2,
            useCORS: true,
            backgroundColor: "#ffffff",
        });

        const isJpg = format === "jpg";
        const mimeType = isJpg ? "image/jpeg" : "image/png";
        const extension = isJpg ? "jpg" : "png";

        canvas.toBlob(
            (blob) => {
                if (!blob) {
                    console.error("Failed to create image blob.");
                    return;
                }

                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");

                link.href = url;
                link.download = `member-card-${card.dataset.memberNumber}.${extension}`;

                document.body.appendChild(link);
                link.click();
                link.remove();

                URL.revokeObjectURL(url);
            },
            mimeType,
            0.95,
        );
    } catch (error) {
        console.error("Failed to generate member card:", error);
    }
};
