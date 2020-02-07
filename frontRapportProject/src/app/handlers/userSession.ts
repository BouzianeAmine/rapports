export function getCurrentUser():User{
    return JSON.parse(localStorage.getItem('user'));
}