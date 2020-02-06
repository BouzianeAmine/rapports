import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-update-user',
  templateUrl: './update-user.component.html',
  styleUrls: ['./update-user.component.css']
})
export class UpdateUserComponent implements OnInit {
  currentUser: User;
  constructor() {
    this.currentUser = JSON.parse(localStorage.getItem('user'));
    console.log(this.currentUser)
  }

  ngOnInit() {

  }
  save() {
    fetch("http://localhost:8000/bootstrap.php/updateUser", { method: 'POST', mode: 'cors', body: JSON.stringify(this.currentUser) })
      .then(()=> localStorage.setItem('user', JSON.stringify(this.currentUser)));
  }

}
