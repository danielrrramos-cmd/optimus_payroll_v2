import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { EmpleadoService } from '../../../services/empleado.service';
import { Empleado } from '../../../models/models';

@Component({
  selector: 'app-empleado-form',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './empleado-form.component.html',
  styleUrl: './empleado-form.component.css'
})
export class EmpleadoFormComponent implements OnInit {
  empleado: Partial<Empleado> = {
    nombre: '', apellidos: '', dni: '',
    salarioBase: 0, irpf: 0, seguridadSocial: 0
  };
  isEditing = false;
  empleadoId: number | null = null;
  error = '';
  guardando = false;

  constructor(
    private empleadoService: EmpleadoService,
    private route: ActivatedRoute,
    private router: Router,
    private cdr: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id) {
      this.isEditing = true;
      this.empleadoId = +id;
      this.empleadoService.getOne(this.empleadoId).subscribe({
        next: (emp) => {
          this.empleado = { ...emp };
          this.cdr.detectChanges();
        },
        error: () => this.router.navigate(['/empleados'])
      });
    }
  }

  /** Normaliza el DNI al formato 77805696-P independientemente de cómo se meta */
  normalizarDni(): void {
    if (!this.empleado.dni) return;
    // Quitar espacios, guiones, puntos existentes y pasar a mayúsculas
    let dni = this.empleado.dni.toUpperCase().replace(/[\s\-_.]/g, '').trim();
    // Si tiene el formato correcto (8 dígitos + 1 letra) añadir el guion
    const match = dni.match(/^(\d{8})([A-Z])$/);
    if (match) {
      this.empleado.dni = `${match[1]}-${match[2]}`;
    } else {
      this.empleado.dni = dni; // dejar limpio aunque no sea DNI válido
    }
  }

  onSubmit(): void {
    this.error = '';
    this.guardando = true;
    this.normalizarDni();

    const accion = (this.isEditing && this.empleadoId)
      ? this.empleadoService.update(this.empleadoId, this.empleado)
      : this.empleadoService.create(this.empleado);

    accion.subscribe({
      next: () => this.router.navigate(['/empleados']),
      error: (err) => {
        this.guardando = false;
        const msg = err?.error?.errors || err?.error?.detail || err?.message || 'Error al guardar';
        this.error = typeof msg === 'string' ? msg : JSON.stringify(msg);
        this.cdr.detectChanges();
      }
    });
  }
}
