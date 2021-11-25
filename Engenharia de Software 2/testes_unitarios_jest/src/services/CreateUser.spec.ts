import { BcryptAdapter } from '../infra/BcryptAdapter';
import { UsersRepository } from '../repositories/UsersRepository';
import { CreateUserUsecase } from './CreateUserUsecase';

let usersRepository: UsersRepository;
let createUserUsecase: CreateUserUsecase;
let encrypter: BcryptAdapter;

describe('Create User', () => {
  beforeEach(() => {
    usersRepository = new UsersRepository();
    encrypter = new BcryptAdapter();
    createUserUsecase = new CreateUserUsecase(usersRepository, encrypter);
  });

  test('Deve ser possível criar um usuário', async () => {
    const user = await createUserUsecase.execute({
      email: 'test@dev.com',
      password: 'pass1234',
      passwordConfirm: 'pass1234',
    });

    expect(user).toHaveProperty('id');
  });

  test('Deve fazer a chamada com os valores corretos', async () => {
    const spy = jest.spyOn(createUserUsecase, 'execute');

    const userData = {
      email: 'test@dev.com',
      password: 'pass1234',
      passwordConfirm: 'pass1234',
    };

    await createUserUsecase.execute(userData);

    expect(spy).toHaveBeenCalledWith({
      email: 'test@dev.com',
      password: 'pass1234',
      passwordConfirm: 'pass1234',
    });
  });

  test('Deve retornar um erro na tentativa de criação de um usuário já existente', async () => {
    const userData = {
      email: 'test@dev.com',
      password: 'pass1234',
      passwordConfirm: 'pass1234',
    };

    await createUserUsecase.execute(userData);

    await expect(createUserUsecase.execute(userData)).rejects.toEqual(
      new Error('Usuário já existe')
    );
  });

  test('Deve retornar um erro quando a senha e a confirmação de senha não forem idênticas', async () => {
    const userData = {
      email: 'test@dev.com',
      password: 'pass1234',
      passwordConfirm: 'pass123456',
    };

    await expect(createUserUsecase.execute(userData)).rejects.toEqual(
      new Error('As senhas não coincidem')
    );
  });

  test('Deve retornar um erro se o encrypter retornar um erro', async () => {
    jest
      .spyOn(encrypter, 'encrypt')
      .mockReturnValueOnce(
        new Promise((resolve, reject) => reject(new Error()))
      );

    const promise = createUserUsecase.execute({
      email: 'valid_email',
      password: 'valid_password',
      passwordConfirm: 'valid_password',
    });

    await expect(promise).rejects.toThrow();
  });

  test('Deve retornar um erro se o usuário não preencher algum campo', async () => {
    const userData = {
      email: 'valid_email',
      password: 'valid_password',
    };

    await expect(createUserUsecase.execute(userData)).rejects.toEqual(
      new Error('Existem campos não preenchidos')
    );
  });
});
