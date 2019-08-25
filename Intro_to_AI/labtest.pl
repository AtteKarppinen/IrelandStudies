% 1.

% Persons
person(john, 20, m, excellent).
person(jane, 40, f, bad).
person(peter, 16, m, good).
person(alfred, 30, m, bad).
person(rose, 20, f, good).

% Drivers
drives(john, honda).
drives(jane, bmw).
drives(alfred, audi).
drives(rose, skoda).

% Drinkers
drinks(john, moderately).
drinks(jane, alot).
drinks(peter, not_at_all).
drinks(alfred, moderately).
drinks(rose, moderately).

% Importants
isImportant(alfred).


eligible(Name) :-   person(Name, Age, _, Fitness),
                    Age > 17, Age < 33,
                    Fitness = excellent.

eligible(Name) :-   person(Name, Age, _, Fitness),
                    Age > 17, Age < 33,
                    Fitness = good,
                    drives(Name, _),
                    (
                        drinks(Name, not_at_all)
                        ;
                        drinks(Name, moderately)    
                    ).

eligible(Name) :-   person(Name, Age, _, _),
                    Age > 17, Age < 33,
                    isImportant(Name).


                
% 5. 

addTo(X, [H], [H2|_]) :-    H2 is X + H.


addTo(X, [H|T], [H1|T]) :-  H1 is X + H,
                            addTo(X, T, [H1|T]).