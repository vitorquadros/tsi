export interface UserData {
  id?: string;
  email: string;
  password: string;
  passwordConfirm?: string;
}

export interface UsersRepositoryModel {
  store(data: UserData): UserData;
  index(): UserData[];
  findByEmail(email: string): UserData;
}
