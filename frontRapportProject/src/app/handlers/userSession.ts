import { User } from '../models/user';
import { Observable } from 'rxjs';

export function getCurrentUser(): Observable<User> {
    return Observable.create(observer => {
        observer.next(toJSON(localStorage.getItem('user')));
        observer.complete();
    });
}

export function stockSession(user: User) {
    localStorage.setItem('user', toString(user));
}

export function soldeBehavior(user: User) {

    if (user != undefined) {
        var date = toJSON(localStorage.getItem('hist'))[1];
        //console.log(user);
        if (testSameConnectionDay()) {
            user.solde++;
            console.log('im here where i shouldn"t be')
            return true;
        }
        console.log('here instead where it should be now')
        return false;
    }
    throw new Error("Not connected to deal with it ");
}

export function toJSON(val) {
    return JSON.parse(val);
}

export function toString(val) {
    return JSON.stringify(val);
}

function dateDiff(d1, d2) {
    d1 = new Date(d1);
    d2 = new Date(d2);
    return new Date((d1 - d2)).getSeconds();
}


export function updateSolde(val: number): Promise<User> {
    return new Promise<User>((resolve, reject) => {
        getCurrentUser().subscribe((user:User) => {
            user.solde = new Number(user.solde ).valueOf()+val;
            console.log(user);
            resolve(user);
        });
    })
}

export function testSameConnectionDay() {
    console.log(Date.now(), toJSON(localStorage.getItem('hist'))[1])
    var res = dateDiff(Date.now(), toJSON(localStorage.getItem('hist'))[1]);
    if (res <= 86400) {
        console.log(res);
        return false;
    }
    console.log(res)
    return true;
}