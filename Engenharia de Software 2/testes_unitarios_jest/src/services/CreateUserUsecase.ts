import { inject, injectable } from 'tsyringe';

import {
  UserData,
  UsersRepositoryModel,
} from '../repositories/UsersRepositoryModel';

import { container } from 'tsyringe';
import { UsersRepository } from '../repositories/UsersRepository';
import { BcryptAdapter, Encrypter } from '../infra/BcryptAdapter';

container.registerSingleton<UsersRepositoryModel>(
  'UsersRepository',
  UsersRepository
);

container.registerSingleton<Encrypter>('BcryptAdapter', BcryptAdapter);

@injectable()
export class CreateUserUsecase {
  constructor(
    @inject('UsersRepository')
    private usersRepository: UsersRepositoryModel,
    @inject('BcryptAdapter')
    private encrypter: Encrypter
  ) {}

  async execute({
    email,
    password,
    passwordConfirm,
  }: UserData): Promise<UserData> {
    const userExists = this.usersRepository.findByEmail(email);

    if (!email || !password || !passwordConfirm) {
      throw new Error('Existem campos não preenchidos');
    }

    if (userExists) throw new Error('Usuário já existe');

    if (passwordConfirm && password && password !== passwordConfirm) {
      throw new Error('As senhas não coincidem');
    }

    const hashedPassword = await this.encrypter.encrypt(password);

    const user = this.usersRepository.store({
      email,
      password: hashedPassword,
    });

    return user;
  }
}
