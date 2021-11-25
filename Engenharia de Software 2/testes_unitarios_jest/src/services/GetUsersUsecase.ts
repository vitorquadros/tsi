import { inject, injectable } from 'tsyringe';

import {
  UserData,
  UsersRepositoryModel,
} from '../repositories/UsersRepositoryModel';

import { container } from 'tsyringe';
import { UsersRepository } from '../repositories/UsersRepository';

container.registerSingleton<UsersRepositoryModel>(
  'UsersRepository',
  UsersRepository
);

@injectable()
export class GetUsersUsecase {
  constructor(
    @inject('UsersRepository')
    private usersRepository: UsersRepositoryModel
  ) {}

  execute(): UserData[] {
    return this.usersRepository.index();
  }
}
