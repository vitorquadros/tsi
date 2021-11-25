import { Request, Response } from 'express';
import { container } from 'tsyringe';
import { GetUsersUsecase } from '../services/GetUsersUsecase';

export class GetUsersController {
  async handle(req: Request, res: Response): Promise<Response> {
    const getUsersUsecase = container.resolve(GetUsersUsecase);

    const users = getUsersUsecase.execute();

    return res.status(200).json({ users });
  }
}
