import {User} from './User';
import {Theme} from './Theme';

export interface UserHasTheme {
	id: number;
	user?: User;
	theme?: Theme;
}