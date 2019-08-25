% Financial Advisor

% atoms:

% rule 1
% savings_account(inadequate) :-
%
% % rule 2
% savings_account(adequate) :-  % amount of savings is adequate?
%
% % rule 3
% income(inadequate) :- % amount of income is inadequate?
%
% % rule 4
% income(adequate) :-   % amount of income is adequate?
%
%
% investment(savings) :-          savings_account(inadequate),
%                                 income(adequate).
%
% investment(savings) :-          savings_account(inadequate),
%                                 income(inadequate).
%
% investment(stocks) :-           savings_account(inadequate),
%                                 income(inadequate).
%
% investment(stocks) :-           savings_account(inadequate),
%                                 income(inadequate).
%
% investment(combinations) :-     savings_account(inadequate),
%                                 income(inadequate).
%
% investment(combinations) :-     savings_account(inadequate),


go :-
  write.

write :-
  write('test'),
  read(E),
  write('test successfull '), write(E).
% getSavings :-
