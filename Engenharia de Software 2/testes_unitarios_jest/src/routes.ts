import { Router } from 'express';
import { CreateUserController } from './controllers/CreateUserController';
import { GetUsersController } from './controllers/GetUsersController';

export const router = Router();

const createUserController = new CreateUserController();
const getUsersController = new GetUsersController();

router.post('/users', createUserController.handle);
router.get('/users', getUsersController.handle);
