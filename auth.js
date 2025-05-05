document.addEventListener('DOMContentLoaded', () => {
    const authBlock = document.querySelector('.header__auth');
    const username = getCookie('user_login');

    if (username && authBlock) {
        // Показываем "Профиль" и "Выйти"
        authBlock.innerHTML = `
            <a href="profile.html" class="btn btn-profile">Профиль</a>
            <a href="#" class="btn btn-logout">Выйти</a>
        `;

        document.querySelector('.btn-logout').addEventListener('click', () => {
            // Удаляем куки
            document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "user_login=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            // Обновляем страницу
            location.reload();
        });
    }
});

function getCookie(name) {
    const matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([$?*|{}\\[\]])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
