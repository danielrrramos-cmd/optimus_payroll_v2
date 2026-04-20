import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { LoginResponse, UserInfo } from '../models/models';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private apiUrl = environment.apiUrl;
  private loggedIn = new BehaviorSubject<boolean>(this.hasToken());

  isLoggedIn$ = this.loggedIn.asObservable();

  constructor(private http: HttpClient) {}

  login(usuario: string, password: string): Observable<LoginResponse> {
    return this.http.post<LoginResponse>(`${this.apiUrl}/login`, { usuario, password }).pipe(
      tap(res => {
        localStorage.setItem('jwt_token', res.token);
        this.loggedIn.next(true);
      })
    );
  }

  logout(): void {
    localStorage.removeItem('jwt_token');
    this.loggedIn.next(false);
  }

  getToken(): string | null {
    return localStorage.getItem('jwt_token');
  }

  getMe(): Observable<UserInfo> {
    return this.http.get<UserInfo>(`${this.apiUrl}/me`);
  }

  isLoggedIn(): boolean {
    return this.hasToken();
  }

  private hasToken(): boolean {
    return !!localStorage.getItem('jwt_token');
  }
}
