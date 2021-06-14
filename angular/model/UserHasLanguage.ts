import {User} from './User';
import {Language} from './Language';

export interface UserHasLanguage {
	id: number;
	priority: any;
	user?: User;
	language?: Language;
}