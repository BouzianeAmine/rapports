import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from './models/user';
import { toString, soldeBehavior, stockSession, testSameConnectionDay, toJSON } from './handlers/userSession';
import { resolve } from 'url';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor() { }

  connect(userCred): Observable<User> {
    return Observable.create(observer => {
      fetch("http://localhost:8000/bootstrap.php/connect", { method: 'POST', mode: 'cors', body: toString(userCred) })
        .then(value => value.json())
        .then((user) => {
          localStorage.setItem('auth', 'true');
          //tester sur la premiere hist d'aujord'hui avant la connexion
          if (soldeBehavior(user)) {
            stockSession(user);
            localStorage.setItem('hist', toString([user, Date.now()]));
          } else {
            console.log("here where it should be instead")
            stockSession(user);
            localStorage.setItem('hist', toString([user, toJSON(localStorage.getItem('hist'))[1]]));
          }
          observer.next(user);
          observer.complete();
        })
    })
  }

  update(user) {
    return new Promise((resolve, reject) => {
      fetch("http://localhost:8000/bootstrap.php/updateUser", { method: 'POST', mode: 'cors', body: toString(user) })
        .then(res => res.json()).then((user: User) => {
          stockSession(user);
          resolve(user);
        }).catch(err=>reject(err));
    })
  }
}
