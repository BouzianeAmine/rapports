import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  isauth: Boolean;
  constructor() { this.isauth = this.isAuth() }

  ngOnInit() {
  }

  public isAuth() {
    return JSON.parse(localStorage.getItem('auth'));
  }
  logout() {
    fetch('http://localhost:8000/bootstrap.php/deconnect', { method: 'POST', mode: 'cors', body: localStorage.getItem('user') })
      .then(res => {
        if (res.ok) {
          localStorage.removeItem('user');
          localStorage.setItem('auth', 'false');
          this.isauth = JSON.parse(localStorage.getItem('auth'))
        }
      });
  }
}
