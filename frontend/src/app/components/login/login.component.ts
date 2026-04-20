import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  usuario = '';
  password = '';
  error = '';

  constructor(private authService: AuthService, private router: Router) {}

  onSubmit(): void {
    this.error = '';
    this.authService.login(this.usuario, this.password).subscribe({
      next: () => this.router.navigate(['/dashboard']),
      error: () => this.error = 'Usuario o contraseña incorrectos'
    });
  }
}
