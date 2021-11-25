import { Request, Response } from 'express';
import { container } from 'tsyringe';
import { CreateUserUsecase } from '../services/CreateUserUsecase';

export class CreateUserController {
  async handle(req: Request, res: Response): Promise<Response> {
    const { email, password, passwordConfirm } = req.body;
    const createUserUsecase = container.resolve(CreateUserUsecase);

    try {
      const user = await createUserUsecase.execute({
        email,
        password,
        passwordConfirm,
      });

      return res.status(201).json(user);
    } catch (error) {
      return res.status(400).json({ error: error.message });
    }
  }
}
