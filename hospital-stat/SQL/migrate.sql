
--  БАЗА ДАННЫХ: hospital_stat
-- Проект: Статистический учет пациентов стационара


SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Logs;
DROP TABLE IF EXISTS MedicalProcedure;
DROP TABLE IF EXISTS Hospitalization;
DROP TABLE IF EXISTS PatientDiagnosis;
DROP TABLE IF EXISTS Diagnosis;
DROP TABLE IF EXISTS Patient;
DROP TABLE IF EXISTS Doctors;
DROP TABLE IF EXISTS Ward;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Users;

SET FOREIGN_KEY_CHECKS = 1;


--  Отделения

CREATE TABLE Department (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Палаты

CREATE TABLE Ward (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    DepartmentId INT NOT NULL,
    WardNumber VARCHAR(10) NOT NULL,
    BedCount INT DEFAULT 1,
    FOREIGN KEY (DepartmentId) REFERENCES Department(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Врачи

CREATE TABLE Doctors (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    Position VARCHAR(100),
    Phone VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Пациенты

CREATE TABLE Patient (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(255) NOT NULL,
    Gender CHAR(1) NOT NULL CHECK (Gender IN ('M','F')),
    BirthDate DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Диагнозы

CREATE TABLE Diagnosis (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    DiagnosisName VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Связь Пациент  Диагноз многие ко многим

CREATE TABLE PatientDiagnosis (
    PatientId INT NOT NULL,
    DiagnosisId INT NOT NULL,
    PRIMARY KEY (PatientId, DiagnosisId),
    FOREIGN KEY (PatientId) REFERENCES Patient(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (DiagnosisId) REFERENCES Diagnosis(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Госпитализации

CREATE TABLE Hospitalization (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    PatientId INT NOT NULL,
    WardId INT NOT NULL,
    DoctorId INT,
    DiagnosisId INT,
    AdmissionDate DATE NOT NULL,
    DischargeDate DATE,
    FOREIGN KEY (PatientId) REFERENCES Patient(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (WardId) REFERENCES Ward(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (DoctorId) REFERENCES Doctors(Id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (DiagnosisId) REFERENCES Diagnosis(Id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Медицинские процедуры

CREATE TABLE MedicalProcedure (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    HospitalizationId INT NOT NULL,
    ProcedureName VARCHAR(255) NOT NULL,
    ProcedureDate DATETIME NOT NULL,
    FOREIGN KEY (HospitalizationId) REFERENCES Hospitalization(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Пользователи авторизация

CREATE TABLE Users (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(100) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    Role ENUM('admin','doctor','statistician') DEFAULT 'doctor',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  Логи действий

CREATE TABLE Logs (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT,
    Action VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserId) REFERENCES Users(Id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
