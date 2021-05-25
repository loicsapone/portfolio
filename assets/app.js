import "@fontsource/arvo/700.css";
import "@fontsource/roboto/400.css";
import "@fontsource/roboto/700.css";
import './styles/app.scss';

// activate animations on sections
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.intersectionRatio > 0) {
            entry.target.classList.add('animate');
        }
    });
});
document.querySelectorAll('#about, #github, #contact').forEach(section => {
    observer.observe(section);
});