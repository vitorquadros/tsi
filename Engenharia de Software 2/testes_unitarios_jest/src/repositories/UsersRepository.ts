import { UserData, UsersRepositoryModel } from './UsersRepositoryModel';
import { v4 as uuid } from 'uuid';

export class UsersRepository implements UsersRepositoryModel {
  users: UserData[] = [];

  store({ email, password, passwordConfirm }: UserData): UserData {
    const user = {} as UserData;

    const id = uuid();

    Object.assign(user, { id, email, password, passwordConfirm });

    this.users.push(user);

    return user;
  }

  index(): UserData[] {
    return this.users;
  }

  findByEmail(email: string): UserData {
    const user = this.users.find((user) => user.email === email);
    return user;
  }
}
