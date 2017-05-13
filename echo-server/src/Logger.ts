import * as Log4js from 'log4js';

export class Logger {
    public static default: Log4js.Logger;

    static initialize(): void {
        this.default = Log4js.getLogger();
        this.default.setLevel('debug');
    }
}