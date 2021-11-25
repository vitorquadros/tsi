import bcrypt from 'bcrypt';

export interface Encrypter {
  encrypt(value: string): Promise<string>;
}

export class BcryptAdapter implements Encrypter {
  async encrypt(value: string): Promise<string> {
    const hash = await bcrypt.hash(value, 12);
    return hash;
  }
}
