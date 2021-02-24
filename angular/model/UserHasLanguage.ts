import {User} from './User';
import {Language} from './Language';

export interface UserHasLanguage {
	id: number;
	level: string;
	user?: User;
	language?: Language;
}