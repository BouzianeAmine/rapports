import { Component, OnInit, Input } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
  @Input() email: string;
  @Input() password: string;
  constructor(private router:Router) { }

  ngOnInit() {
  }

  connect() {
    const user = {
      email: this.email,
      password: this.password
    };
    fetch("http://localhost:8000/bootstrap.php/connect", { method: 'POST', mode: 'cors', body: JSON.stringify(user) })
      .then(value => value.json())
      .then(user => {
        localStorage.setItem('auth','true');
        localStorage.setItem("user", JSON.stringify(user));
        this.router.navigate(['']);
      });
  }

}
